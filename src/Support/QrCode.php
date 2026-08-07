<?php

declare(strict_types=1);

namespace BlueStarSystem\AuraUI\Support;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Throwable;

/**
 * A QR code, drawn on the server.
 *
 * Rendering it here rather than in the browser keeps the page free of a script
 * that draws to a canvas — which a content security policy usually blocks, and
 * which produces an image with no text alternative at all.
 *
 * The encoder is optional. If `bacon/bacon-qr-code` is not installed the
 * component still renders its text alternative, because the readable form of a
 * QR code is the thing it encodes, and that is what anyone who cannot scan it
 * needs anyway.
 */
final class QrCode
{
    public static function available(): bool
    {
        return class_exists(Writer::class);
    }

    /**
     * Inline SVG for the value, or null when no encoder is installed or the
     * value cannot be encoded (too long for the chosen correction level).
     */
    public static function svg(string $value, int $size = 200, int $margin = 1): ?string
    {
        if ($value === '' || ! self::available()) {
            return null;
        }

        try {
            $writer = new Writer(new ImageRenderer(
                new RendererStyle(max(48, $size), max(0, $margin)),
                new SvgImageBackEnd,
            ));

            $svg = $writer->writeString($value);
        } catch (Throwable) {
            return null;
        }

        // The writer emits a standalone document; inlining its XML declaration
        // inside HTML is invalid and some parsers give up at that point.
        $svg = preg_replace('/<\?xml.*?\?>\s*/s', '', $svg) ?? '';

        return $svg === '' ? null : trim($svg);
    }
}
