<?php

use BlueStarSystem\AuraUI\Commands\InstallCommand;

/**
 * `vendor:publish` refuses to overwrite a file that already exists. For the
 * config that is the right behaviour — the application owns it. For the copy of
 * the stylesheet under resources/css/vendor it is not: upgrading the package
 * left the old copy in place, with no error, so new rules never reached the
 * build. It happened twice on the same afternoon the x-cloak rule was added,
 * and it was only noticed because someone was looking for that exact rule.
 */
it('forces the copies and leaves the config alone', function () {
    $source = (string) file_get_contents(__DIR__.'/../../src/Commands/InstallCommand.php');

    // Everything between one publish call and the next.
    $calls = preg_split("/callSilently\('vendor:publish',/", $source);
    array_shift($calls);

    expect($calls)->toHaveCount(3);

    $forced = [];
    foreach ($calls as $call) {
        $block = substr($call, 0, (int) strpos($call, ']'));
        preg_match("/'aura-ui-[a-z]+'/", $block, $tag);
        $forced[trim($tag[0] ?? '?', "'")] = str_contains($block, "'--force' => true");
    }

    expect($forced)->toBe([
        'aura-ui-config' => false,
        'aura-ui-css' => true,
        'aura-ui-assets' => true,
    ]);
});

it('tells the reader to import the stylesheet from vendor, which cannot go stale', function () {
    $source = (string) file_get_contents(__DIR__.'/../../src/Commands/InstallCommand.php');

    expect($source)
        ->toContain("@import '../../vendor/bluestarsystem/aura-ui/resources/css/aura.css';")
        ->toContain("@source '../../vendor/bluestarsystem/aura-ui/resources/views/**/*.blade.php';");
});

it('is still registered under the same name', function () {
    expect((new ReflectionClass(InstallCommand::class))->getDefaultProperties()['signature'])
        ->toBe('aura:install');
});
