<?php

namespace LeandroGRG\ListMaker\Traits;

trait RendersLists
{
    protected $templatePath;

    public function render ()
    {
        $path = 'app/Helpers/ListTemplates';
        $this->templatePath = base_path($path . '/' . studly_case($this->name) . '/ListTemplate.html');
        $template = file_get_contents($this->templatePath);
        $class = 'App\\Helpers\\ListTemplates\\' . studly_case($this->name) . '\\' . studly_case($this->name) . 'ListParser';
        return strtr($template, $class::parse($this));
    }

    public function renderItems ()
    {
        $str = '';
        foreach ($this->items as $item) {
            $str.= $item->render($this);
        }
        return $str;
    }
}
