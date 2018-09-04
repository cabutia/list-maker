<?php

namespace LeandroGRG\ListMaker\Traits;

trait RendersListChilds
{
    protected $templatePath;

    public function render ($list)
    {
        $path = 'app/Helpers/ListTemplates';
        $this->templatePath = base_path($path . '/' . studly_case($list->name) . '/');
        $template = file_get_contents($this->templatePath . studly_case($this->type) . 'Template.html');
        $class = 'App\\Helpers\\ListTemplates\\' . studly_case($list->name) . "\\" . studly_case($list->name) . 'ItemParser';
        $method = "parse" . ucwords($this->type) . "Type";
        return strtr($template, $class::$method($this));
    }
}
