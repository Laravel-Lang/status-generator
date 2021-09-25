<?php

namespace LaravelLang\StatusGenerator\Facades;

use Helldar\Support\Facades\Facade;
use LaravelLang\StatusGenerator\Support\Finder;
use LaravelLang\StatusGenerator\Support\Package as Support;
use LaravelLang\StatusGenerator\Support\Parser;
use Symfony\Component\Finder\Finder as SymfonyFinder;

/**
 * @method static Support some()
 */
class Package extends Facade
{
    protected static function getFacadeAccessor(): Support
    {
        return new Support(self::resolveFinder(), self::resolveParser());
    }

    protected static function resolveFinder(): Finder
    {
        $finder = SymfonyFinder::create();

        return Finder::make($finder);
    }

    protected static function resolveParser(): Parser
    {
        return Parser::make();
    }
}
