<?php

namespace LeandroGRG\ListMaker;

use \LeandroGRG\ListMaker\Models\BaseListModel;

class ListGen {

    public $list;

    public static function make ($list)
    {
        $class = new self($list);
        return $class->render();
    }

    public function __construct ($list)
    {
        $this->list = BaseListModel::where('name', $list)->firstOr(null);
    }


    private function render ()
    {
        if ($this->list) {
            echo $this->list->render();
        }
    }

}
