<?php
class PodcastsStore {
    private string $file;
    private array  $data;

    public function __construct(string $file) {
        $this->file = $file;
        $this->load();
    }

    private function load(): void {
        if (!file_exists($this->file)) {
            $this->data = [];
            return;
        }
        $this->data = json_decode(file_get_contents($this->file), true) ?? [];
    }

    private function save(): void {
        file_put_contents($this->file, json_encode($this->data, JSON_PRETTY_PRINT));
    }

    public function all(): array {
        return $this->data;
    }

    public function add(string $name, string $handle): void {
        // Avoid duplicates
        foreach ($this->data as $p) {
            if ($p['handle'] === $handle) return;
        }
        $this->data[] = ['name' => $name, 'handle' => $handle];
        $this->save();
    }

    public function remove(string $handle): void {
        $this->data = array_values(array_filter($this->data, fn($p) => $p['handle'] !== $handle));
        $this->save();
    }

    public function exists(string $handle): bool {
        foreach ($this->data as $p) {
            if ($p['handle'] === $handle) return true;
        }
        return false;
    }
}
