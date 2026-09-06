<?php

use Symfony\Component\Finder\Finder;

/**
 * A tag that writes a literal class="" and then dumps the raw attribute bag
 * gives a caller who passed class="..." two class attributes; the HTML parser
 * keeps the first and silently drops theirs. Reported twice by the TempGuard
 * team (dropdown, then steps). Every component must merge through
 * $attributes->class() or ->merge() instead.
 */
it('never writes a literal class before the raw attribute bag on the same tag', function () {
    $offenders = [];

    foreach (Finder::create()->files()->name('*.blade.php')->in(__DIR__.'/../../../resources/views/components') as $file) {
        $source = preg_replace('/\{\{--.*?--\}\}/s', '', $file->getContents());

        // The raw bag, or ->except() of anything but class: both would emit a
        // second class attribute if the caller passed one.
        preg_match_all('/\{\{\s*\$attributes(?:->except\((?![^)]*class)[^)]*\))?\s*\}\}/', $source, $bags, PREG_OFFSET_CAPTURE);

        foreach ($bags[0] as [$bag, $offset]) {
            $tagStart = strrpos(substr($source, 0, $offset), '<');
            $tag = substr($source, $tagStart, $offset - $tagStart);

            if (preg_match('/(?<![:\w-])class="/', $tag)) {
                $offenders[] = $file->getRelativePathname();
                break;
            }
        }
    }

    expect($offenders)->toBe([], 'Literal class before {{ $attributes }} in: '.implode(', ', $offenders));
});
