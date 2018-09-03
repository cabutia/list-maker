<?php

namespace LeandroGRG\ListMaker\Models;

use Illuminate\Database\Eloquent\Model;

class BaseListItemModel extends Model {

    use \LeandroGRG\ListMaker\Traits\RendersListChilds;

    protected $table = 'list_items';

    protected $fillable = [
      'list_id',
      'type',
      'route',
      'icon',
      'display',
      'order'
    ];

    protected $hidden = [
      'id'
    ];

    public function moveUp ($pos = 1)
    {
        return $this->update([
            'order' => $this->order + $pos
        ]);
    }

    public function moveDown ($pos = 1)
    {
        return $this->update([
            'order' => $this->order - $pos
        ]);
    }

    public function next ()
    {
        $model = new $this();
        return $model->where([
            ['aside', '=', $this->aside],
            ['order', '>', $this->order]
        ])->first();
    }

    public function prev ()
    {
        $model = new $this();
        return $model->where([
            ['aside', '=', $this->aside],
            ['order', '<', $this->order]
        ])->first();
    }

    public function list ()
    {
        return $this->belongsTo('LeandroGRG\ListMaker\Models\ListModel');
    }

    public function getPrettyNameAttribute ()
    {
        return ucfirst(str_replace('-', ' ', $this->name));
    }

}
