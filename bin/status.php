<?php

use LaravelLang\StatusGenerator\Processors\Statuses\Locales;
use LaravelLang\StatusGenerator\Processors\Statuses\Main;

require __DIR__ . '/../vendor/autoload.php';

/** @var \LaravelLang\StatusGenerator\Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->processor(Main::make());
$app->processor(Locales::make());
