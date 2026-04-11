<?php
/**
 * TemplatesStore - saves description templates to server JSON
 */
class TemplatesStore {
    private string $file;
    private array  $data;

    public function __construct(string $file) {
        $this->file = $file;
        $this->load();
    }

    private function load(): void {
        if (!file_exists($this->file)) {
            // Seed with a default example template
            $this->data = [
                [
                    'id'          => 'default',
                    'name'        => 'Plantilla base',
                    'description' => "En este episodio:\n\n- \n- \n- \n\n---\n\nSigueme en:\n- Web: \n- Mastodon: \n- YouTube: ",
                    'created_at'  => date('Y-m-d H:i:s'),
                ]
            ];
            $this->save();
            return;
        }
        $this->data = json_decode(file_get_contents($this->file), true) ?? [];
    }

    private function save(): void {
        file_put_contents($this->file, json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function all(): array {
        return $this->data;
    }

    public function get(string $id): ?array {
        foreach ($this->data as $t) {
            if ($t['id'] === $id) return $t;
        }
        return null;
    }

    public function add(string $name, string $description): string {
        $id = uniqid('tpl_', true);
        $this->data[] = [
            'id'          => $id,
            'name'        => $name,
            'description' => $description,
            'created_at'  => date('Y-m-d H:i:s'),
        ];
        $this->save();
        return $id;
    }

    public function update(string $id, string $name, string $description): void {
        foreach ($this->data as &$t) {
            if ($t['id'] === $id) {
                $t['name']        = $name;
                $t['description'] = $description;
                $t['updated_at']  = date('Y-m-d H:i:s');
                break;
            }
        }
        $this->save();
    }

    public function delete(string $id): void {
        if ($id === 'default') return; // protect the default
        $this->data = array_values(array_filter($this->data, fn($t) => $t['id'] !== $id));
        $this->save();
    }
}
