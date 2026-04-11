<?php
/**
 * LocalDraftsStore - saves episode form drafts to server-side JSON
 * Keyed by podcast handle so each podcast has its own drafts
 */
class LocalDraftsStore {
    private string $file;
    private array  $data;

    public function __construct(string $file) {
        $this->file = $file;
        $this->load();
    }

    private function load(): void {
        if (!file_exists($this->file)) { $this->data = []; return; }
        $this->data = json_decode(file_get_contents($this->file), true) ?? [];
    }

    private function save(): void {
        file_put_contents($this->file, json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /** Save or update a draft. Returns draft id. */
    public function save_draft(string $podcastHandle, array $fields): string {
        $id = $fields['draft_id'] ?? uniqid('draft_', true);
        if (!isset($this->data[$podcastHandle])) $this->data[$podcastHandle] = [];

        $this->data[$podcastHandle][$id] = array_merge($fields, [
            'draft_id'   => $id,
            'saved_at'   => date('Y-m-d H:i:s'),
            'podcast'    => $podcastHandle,
        ]);
        $this->save();
        return $id;
    }

    /** Get all drafts for a podcast handle, newest first. */
    public function get_drafts(string $podcastHandle): array {
        $drafts = $this->data[$podcastHandle] ?? [];
        usort($drafts, fn($a, $b) => strcmp($b['saved_at'] ?? '', $a['saved_at'] ?? ''));
        return array_values($drafts);
    }

    /** Get a single draft by id. */
    public function get_draft(string $podcastHandle, string $id): ?array {
        return $this->data[$podcastHandle][$id] ?? null;
    }

    /** Delete a draft. */
    public function delete_draft(string $podcastHandle, string $id): void {
        unset($this->data[$podcastHandle][$id]);
        $this->save();
    }

    /** Delete all drafts for a podcast (after publishing). */
    public function clear_podcast_drafts(string $podcastHandle): void {
        unset($this->data[$podcastHandle]);
        $this->save();
    }
}
