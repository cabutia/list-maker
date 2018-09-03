<?php

namespace LeandroGRG\ListMaker\Traits;

trait RendersLists
{
    protected $templatePath;
    protected $templateFile = 'ListTemplate.html';

    public function render ()
    {
        $this->templatePath = config('listmaker.templates.path') . '/' . studly_case($this->name) . '/';

        $template = file_get_contents(base_path($this->templatePath . $this->templateFile));

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
