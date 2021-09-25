<?php

namespace LaravelLang\StatusGenerator\Facades;

use Dotenv\Repository\AdapterRepository;
use Dotenv\Repository\RepositoryInterface;
use Helldar\Support\Facades\Facade;
use LaravelLang\StatusGenerator\Support\Env as Support;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static AdapterRepository|RepositoryInterface getRepository()
 */
class Env extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
