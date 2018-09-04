<?php

namespace LeandroGRG\ListMaker\Commands;

use Illuminate\Console\Command;
use \LeandroGRG\ListMaker\Models\BaseListModel;

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

        $model = new BaseListModel;
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
            $this->createTemplates($list);
            $this->info('List "' . $list->pretty_name . '" created successfully!');
        } catch (\Exception $e) {
            $this->error('There was a problem creating the list');
            $this->error($e->getMessage());
        }
    }

    /**
     * Creates the list templates
     *
     * @param  Illuminate\Database\Eloquent\Model $list
     * @return Illuminate\Database\Eloquent\Model
     */
    private function createTemplates ($list)
    {
        try {
            $path = 'app/Helpers/ListTemplates';
            $studlyName = studly_case($list->name);
            if (! file_exists("{$path}/{$studlyName}")) {
                mkdir("{$path}/{$studlyName}", 0755, true);
            }

            $templates = [
                'ListParser' => $this->getTemplate('ListParser.php', ['StudlyName' => $studlyName]),
                'ItemParser' => $this->getTemplate('ItemParser.php', ['StudlyName' => $studlyName]),
                'ListTemplate' => $this->getTemplate('ListTemplate.html'),
                'ItemTemplate' => $this->getTemplate('ItemTemplate.html'),
                'DividerTemplate' => $this->getTemplate('DividerTemplate.html'),
            ];

            file_put_contents("{$path}/{$studlyName}/{$studlyName}ListParser.php", $templates['ListParser']);
            file_put_contents("{$path}/{$studlyName}/{$studlyName}ItemParser.php", $templates['ItemParser']);
            file_put_contents("{$path}/{$studlyName}/ListTemplate.html", $templates['ListTemplate']);
            file_put_contents("{$path}/{$studlyName}/ItemTemplate.html", $templates['ItemTemplate']);
            file_put_contents("{$path}/{$studlyName}/DividerTemplate.html", $templates['DividerTemplate']);

            return $list;
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /**
     * Reads and parses the specified template
     *
     * @param  string $template
     * @param  array  $data
     * @return string
     */
    private function getTemplate($template, $data = [])
    {
        $path = __DIR__ . '/FileTemplates/' . $template;
        $template = file_get_contents($path);
        $replace = [];
        foreach ($data as $property => $value) {
            $replace["{%" . $property . "%}"] = $value;
        }
        return strtr($template, $replace);
    }
}
