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

    public function createTemplates ()
    {
         $path = config('listmaker.templates.path');
         try {
             $studlyName = studly_case($this->name);
             mkdir("{$path}/{$studlyName}");

             $template = join(PHP_EOL, [
                 "<?php",
                 "",
                 'namespace App\\Helpers\\ListTemplates\\' . $studlyName . ';',
                 '',
                 "class {$studlyName}ListParser",
                 "{",
                 "\tstatic function parse (\$list)",
                 "\t{",
                 "\t\treturn [",
                 "\t\t\t'%ITEMS%' => \$list->renderItems()",
                 "\t\t];",
                 "\t}",
                 "}"
             ]);

             $itemsTemplate = join(PHP_EOL, [
                 "<?php",
                 "",
                 'namespace App\\Helpers\\ListTemplates\\' . $studlyName . ';',
                 '',
                 "class {$studlyName}ItemParser",
                 "{",
                 "\tstatic function parseItemType (\$item)",
                 "\t{",
                 "\t\treturn [",
                 "\t\t\t'%DISPLAY%' => \$item->display",
                 "\t\t];",
                 "\t}",
                 "",
                 "\tstatic function parseDividerType (\$item)",
                 "\t{",
                 "\t\treturn [];",
                 "\t}",
                 "}"
             ]);

             $listTemplate = join(PHP_EOL, [
                 "<!-- This is the list template -->",
                 "<ul>",
                 "\t%ITEMS%",
                 "</ul>"
             ]);

             $itemTemplate = join(PHP_EOL, [
                 "<!-- This is the list item template -->",
                 "<li>",
                 "\t%DISPLAY%",
                 "</li>"
             ]);

             $dividerTemplate = join(PHP_EOL, [
                 "<!-- This is the list divider template -->",
                 "<hr>"
             ]);

             file_put_contents("{$path}/{$studlyName}/{$studlyName}ListParser.php", $template);
             file_put_contents("{$path}/{$studlyName}/{$studlyName}ItemParser.php", $itemsTemplate);
             file_put_contents("{$path}/{$studlyName}/ListTemplate.html", $listTemplate);
             file_put_contents("{$path}/{$studlyName}/ItemTemplate.html", $itemTemplate);
             file_put_contents("{$path}/{$studlyName}/DividerTemplate.html", $dividerTemplate);

             return $this;
         } catch (\Exception $e) {
             throw new \Exception($e);
         }

    }

}
