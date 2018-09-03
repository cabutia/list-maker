<?php

namespace LeandroGRG\ListMaker;

use Illuminate\Database\Eloquent\Model;

class ListGen {

    public $list;

    public static function make ($list)
    {
        $class = new self($list);
        return $class->render();
    }

    public function __construct ($list)
    {
        $this->list = \LeandroGRG\ListMaker\Models\BaseListModel::where('name', $list)->first();
    }


    private function render ()
    {
        if ($this->list) {
            echo $this->list->render();
        }
    }

}
