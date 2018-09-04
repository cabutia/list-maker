<?php

namespace LeandroGRG\ListMaker\Models;

use Illuminate\Database\Eloquent\Model;

class BaseListItemModel extends Model {

    use \LeandroGRG\ListMaker\Traits\RendersListChilds;

    /**
     * The model's table
     * @var string
     */
    protected $table = 'list_items';

    /**
     * The fillable model properties
     * @var array
     */
    protected $fillable = [
      'list_id',
      'type',
      'route',
      'icon',
      'display',
      'order'
    ];


    /**
     * The hidden model properties
     * @var array
     */
    protected $hidden = [
      'id'
    ];


    /**
     * Updates the item's order (order +1)
     * @param  integer $pos
     * @return boolean
     */
    public function moveUp ($pos = 1)
    {
        return $this->update([
            'order' => $this->order + $pos
        ]);
    }


    /**
     * Updates the item's order (order - 1)
     * @param  integer $pos
     * @return boolean
     */
    public function moveDown ($pos = 1)
    {
        return $this->update([
            'order' => $this->order - $pos
        ]);
    }


    /**
     * Returns the next item based on the order
     * @return Illuminate\Database\Eloquent\Model
     */
    public function next ()
    {
        $model = new $this();
        return $model->where([
            ['aside', '=', $this->aside],
            ['order', '>', $this->order]
        ])->first();
    }


    /**
     * Returns the previous item based on the order
     * @return Illuminate\Database\Eloquent\Model
     */
    public function prev ()
    {
        $model = new $this();
        return $model->where([
            ['aside', '=', $this->aside],
            ['order', '<', $this->order]
        ])->first();
    }


    /**
     * The relationship to the parent lists
     * @return Illuminate\Database\Eloquent\Model
     */
    public function list ()
    {
        return $this->belongsTo('LeandroGRG\ListMaker\Models\ListModel');
    }


    /**
     * Returns the formatted name string
     * @return string
     */
    public function getPrettyNameAttribute ()
    {
        return ucfirst(str_replace('-', ' ', $this->name));
    }

}
