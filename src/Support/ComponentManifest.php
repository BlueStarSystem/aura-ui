<?php

namespace BlueStarSystem\AuraUI\Support;

use InvalidArgumentException;

final class ComponentManifest
{
    /** @param array<string, array{tier:string, type?:string, files:list<string>, deps:list<string>}> $entries */
    public function __construct(private array $entries) {}

    /** @param list<string> $paths */
    public static function fromJsonFiles(array $paths): self
    {
        $merged = [];

        foreach ($paths as $path) {
            if (! is_file($path)) {
                continue;
            }

            $decoded = json_decode((string) file_get_contents($path), true);

            if (is_array($decoded)) {
                $merged = array_merge($merged, $decoded);
            }
        }

        return new self($merged);
    }

    public function has(string $name): bool
    {
        return isset($this->entries[$name]);
    }

    /** @return array{tier:string, type?:string, files:list<string>, deps:list<string>} */
    public function get(string $name): array
    {
        if (! $this->has($name)) {
            throw new InvalidArgumentException("Unknown Aura component: {$name}");
        }

        return $this->entries[$name];
    }

    public function tier(string $name): string
    {
        return $this->get($name)['tier'];
    }

    public function type(string $name): string
    {
        return $this->get($name)['type'] ?? 'component';
    }

    /** @return list<string> */
    public function resolve(string $name): array
    {
        $ordered = [];
        $this->collect($name, $ordered);

        return array_values(array_unique($ordered));
    }

    /** @param list<string> $ordered */
    private function collect(string $name, array &$ordered): void
    {
        if (! $this->has($name) || in_array($name, $ordered, true)) {
            return;
        }

        foreach ($this->get($name)['deps'] as $dep) {
            if ($dep !== $name && $this->has($dep)) {
                $this->collect($dep, $ordered);
            }
        }

        $ordered[] = $name;
    }

    /** @return array<string, array> */
    public function all(): array
    {
        return $this->entries;
    }
}
