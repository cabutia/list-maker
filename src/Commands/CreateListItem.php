<?php

namespace LeandroGRG\ListMaker\Commands;

use Illuminate\Console\Command;

class CreateListItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:create-list-item';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $itemModel = new \LeandroGRG\ListMaker\Models\BaseListItemModel;
        $listModel = new \LeandroGRG\ListMaker\Models\BaseListModel;
        $fillable = $itemModel->getFillable();
        $sluggable = [
            'type'
        ];
        $hidden = [
            'list_id'
        ];


        $lists = $listModel::all();
        $map = $options = [];
        foreach ($lists as $list) {
            $map[ucwords($list->name) . ' list'] = $list;
            $options[] = ucwords($list->name) . ' list';
        }

        $parent = $map[$this->choice('Select parent list', $options)];

        $properties = [];
        foreach ($fillable as $property) {
            if (!in_array($property, $hidden)) {
                $value = $this->ask('Enter value for [' . $property . '] property');
                if (!is_null($value)) {
                    $properties[$property] = in_array($value, $sluggable) ? str_slug($value) : $value;
                }
            }
        }

        try {
            $item = $parent->items()->create($properties);
            $this->info('Item "' . $item->display . '" created successfully');
        } catch (\Exception $e) {
            $this->error('There was a problem creating the item');
            $this->error($e->getMessage());
        }
    }
}
