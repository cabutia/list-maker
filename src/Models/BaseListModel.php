<?php

namespace LeandroGRG\ListMaker\Models;

use Illuminate\Database\Eloquent\Model;

class BaseListModel extends Model {

    use \LeandroGRG\ListMaker\Traits\RendersLists;

    protected $table = 'lists';

    protected $fillable = [
        'name'
    ];

    public function items ()
    {
        return $this->hasMany('LeandroGRG\ListMaker\Models\BaseListItemModel', 'list_id', 'id');
    }

    public function getPrettyNameAttribute ()
    {
        return ucfirst(str_replace('-', ' ', $this->name));
    }

}
