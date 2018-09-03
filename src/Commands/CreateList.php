<?php

namespace LeandroGRG\ListMaker\Commands;

use Illuminate\Console\Command;

class CreateList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:create-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new list';

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
        $model = new \LeandroGRG\ListMaker\Models\BaseListModel;
        $fillable = $model->getFillable();
        $sluggable = [
            'name'
        ];

        $properties = [];
        foreach ($fillable as $property) {
            $value = $this->ask('Enter value for [' . $property . '] property');
            $properties[$property] = in_array($property, $sluggable) ? str_slug($value) : $value;
        }

        try {
            $list = $model::create($properties);
            $list->createTemplates();
            $this->info('List "' . $properties['name'] . '" created successfully!');
        } catch (\Exception $e) {
            $this->error('There was a problem creating the list');
            $this->error($e->getMessage());
        }
    }
}
