<?php

namespace App\Helpers\ListTemplates\{%StudlyName%};

class {%StudlyName%}ListParser
{
    static function parse ($list)
    {
        return [
            '%ITEMS%' => $list->renderItems()
        ];
    }
}
