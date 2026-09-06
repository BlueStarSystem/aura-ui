<?php

namespace BlueStarSystem\AuraUI\Tests\Unit;

use BlueStarSystem\AuraUI\Tests\ComponentOverrideTestCase;
use Illuminate\Support\Facades\Blade;

/**
 * loadViewsFrom() looks in resources/views/vendor/{namespace} before the
 * package directory; Blade::anonymousComponentPath() does not, so a single
 * published component in resources/views/vendor/aura/components was silently
 * ignored -- the docs promised otherwise.
 */
class ComponentOverrideTest extends ComponentOverrideTestCase
{
    public function test_it_renders_the_published_component_instead_of_the_package_one(): void
    {
        $html = Blade::render('<x-aura::badge>New</x-aura::badge>');

        $this->assertStringContainsString('overridden-badge', $html);
        $this->assertStringNotContainsString('aura-badge', $html);
    }

    public function test_it_still_renders_the_package_component_when_no_override_exists(): void
    {
        $html = Blade::render('<x-aura::button>Go</x-aura::button>');

        $this->assertStringContainsString('aura-btn', $html);
    }

    public function test_it_registers_the_override_directory_first_and_only_once(): void
    {
        $paths = collect(Blade::getAnonymousComponentPaths())
            ->where('prefix', 'aura')
            ->pluck('path')
            ->map(fn ($p) => str_replace(DIRECTORY_SEPARATOR, '/', $p));

        $this->assertSame(1, $paths->filter(fn ($p) => str_contains($p, 'vendor/aura/components'))->count());
        $this->assertStringContainsString('vendor/aura/components', $paths->first());
    }
}
