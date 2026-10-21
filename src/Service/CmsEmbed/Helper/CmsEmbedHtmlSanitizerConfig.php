<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed\Helper;

use App\Contract\CmsEmbed\CmsEmbedInterface;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

use function array_key_exists;
use function in_array;

class CmsEmbedHtmlSanitizerConfig extends HtmlSanitizerConfig
{
    private static array $additionAttributes = [
        'contenteditable',
        'data-cms-embed-id',
        'data-help-param-id',
    ];

    private function resolveAttributes(iterable $cmsEmbedItems): array
    {
        $attributes = [];

        foreach (self::$additionAttributes as $attribute) {
            $attributes[] = $attribute;
        }

        /** @var CmsEmbedInterface[] $cmsEmbedItems */
        foreach ($cmsEmbedItems as $cmsEmbed) {
            $params = $cmsEmbed->getParams();

            foreach ($params as $param) {
                $id = array_key_exists('id', $param) ? 'data-' . $param['id'] : null;

                if ($id && !in_array($id, $attributes, true)) {
                    $attributes[] = $id;
                }
            }
        }

        return $attributes;
    }

    public function allowCmsEmbedItems(iterable $cmsEmbedItems): static
    {
        $attributes = $this->resolveAttributes($cmsEmbedItems);

        $clone = clone $this;

        foreach ($attributes as $attribute) {
            $clone = $clone->allowAttribute($attribute, '*');
        }

        return $clone;
    }
}
