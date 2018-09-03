<?php

return [
    'models' => [
        'list' => LeandroGRG\ListMaker\Models\ListModel::class,
        'item' => LeandroGRG\ListMaker\Models\ListItemModel::class
    ],

    'tables' => [
        'lists-table' => 'lists',
        'list-items-table' => 'list_items'
    ],

    'templates' => [
        'path' => 'app/Helpers/ListTemplates'
    ]
];
