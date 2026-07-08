<?php

namespace Lumina\ApiV2\Transformers;

use Lumina\ApiV2\Blocks\TransformerRegistry;
use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Str;

class BlocksTransformer
{
    public static function transform(string $content): array
    {
        $blocks = parse_blocks($content);
        $result = [];

        foreach ($blocks as $block) {
            if (empty($block['blockName'])) {
                continue;
            }

            $transformed = self::transformBlock($block);

            if ($transformed !== null) {
                $result[] = $transformed;
            }
        }

        return $result;
    }

    private static function transformBlock(array $block): ?array
    {
        $name = $block['blockName'];
        $transformers = TransformerRegistry::all();

        if (isset($transformers[$name])) {
            $class = $transformers[$name];

            return $class::transform($block);
        }

        $data = AcfBlockData::extract($block);

        if ($data === []) {
            return null;
        }

        return BlockResponse::make(self::blockType($name), $data);
    }

    private static function blockType(string $blockName): string
    {
        return Str::startsWith($blockName, 'acf/')
            ? substr($blockName, 4)
            : $blockName;
    }
}
