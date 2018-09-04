<?php

namespace App\Helpers\ListTemplates\{%StudlyName%};

class {%StudlyName%}ItemParser
{
    static function parseItemType ($item)
    {
        return [
            '%DISPLAY%' => $item->display
        ];
    }

    static function parseDividerType ($item)
    {
        return [];
    }
}
