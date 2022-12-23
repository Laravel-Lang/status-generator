<?php

namespace Tests\Unit\Commands\Download;

use LaravelLang\StatusGenerator\Constants\Command;
use LaravelLang\StatusGenerator\Constants\Option;

class CleanUpTest extends Base
{
    public function testDownload(): void
    {
        $this->command(Command::DOWNLOAD, [
            Option::URL()     => 'https://github.com/laravel/framework/archive/refs/heads/9.x.zip',
            Option::PROJECT() => 'framework',
            Option::VERSION() => '9.x',
        ]);

        $this->assertDirectoryDoesNotExist($this->tempPath('tmp'));
    }
}
