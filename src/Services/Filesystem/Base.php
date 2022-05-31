<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use LaravelLang\StatusGenerator\Application;
use LaravelLang\StatusGenerator\Concerns\Storable;
use LaravelLang\StatusGenerator\Contracts\Filesystem;

abstract class Base implements Filesystem
{
    use Makeable;
    use Storable;

    protected Application $app;

    public function application(Application $app): Filesystem
    {
        $this->app = $app;

        return $this;
    }

    public function load(string $path): array
    {
        return [];
    }

    protected function correctValues(array $items): array
    {
        $callback = static fn ($value) => stripslashes($value);

        return Arrayable::of($items)
            ->map($callback, true)
            ->renameKeys($callback)
            ->get();
    }
}
