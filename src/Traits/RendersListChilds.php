<?php

namespace LeandroGRG\ListMaker\Traits;

trait RendersListChilds
{
    protected $templatePath;
    protected $templateString = '';

    public function render ($list)
    {
        $config = config('listmaker.templates');
        $path = $config['path'] . '/';

        $this->templatePath = base_path($path) . studly_case($list->name) . '/';
        $template = file_get_contents($this->templatePath . studly_case($this->type) . 'Template.html');

        $class = 'App\\Helpers\\ListTemplates\\' . studly_case($list->name) . "\\" . studly_case($list->name) . 'ItemParser';

        $method = "parse" . ucwords($this->type) . "Type";
        return strtr($template, $class::$method($this));
    }
}
