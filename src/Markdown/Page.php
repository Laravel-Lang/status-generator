<?php

namespace LaravelLang\StatusGenerator\Markdown;

use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Constants\Stub;
use LaravelLang\StatusGenerator\Facades\Template;

class Page extends Base
{
    protected string $template;

    public function __toString()
    {
        return Str::replaceFormat($this->template, $this->data, '{{%s}}');
    }

    public function stub(Stub $stub): self
    {
        $this->template = Template::read($stub);

        return $this;
    }
}
