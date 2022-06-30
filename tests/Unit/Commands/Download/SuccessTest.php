<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Download;

use LaravelLang\StatusGenerator\Constants\Command;
use LaravelLang\StatusGenerator\Constants\Option;

class SuccessTest extends Base
{
    public function testDownload(): void
    {
        $this->download('https://github.com/laravel/framework/archive/refs/heads/9.x.zip', 'framework', '9.x');
        $this->download('https://github.com/laravel/framework/archive/refs/heads/8.x.zip', 'framework', '8.x');

        $this->download('https://github.com/laravel/laravel/archive/refs/heads/9.x.zip', 'laravel', '9.x', ['lang']);
        $this->download('https://github.com/laravel/laravel/archive/refs/heads/8.x.zip', 'laravel', '8.x', ['lang', 'resources/lang']);

        $this->assertFileExists($this->tempPath('source/framework/9.x/framework.json'));
        $this->assertFileExists($this->tempPath('source/framework/8.x/framework.json'));

        $this->assertFileExists($this->tempPath('source/laravel/9.x/auth.php'));
        $this->assertFileExists($this->tempPath('source/laravel/9.x/pagination.php'));
        $this->assertFileExists($this->tempPath('source/laravel/9.x/passwords.php'));
        $this->assertFileExists($this->tempPath('source/laravel/9.x/validation.php'));

        $this->assertFileExists($this->tempPath('source/laravel/8.x/auth.php'));
        $this->assertFileExists($this->tempPath('source/laravel/8.x/pagination.php'));
        $this->assertFileExists($this->tempPath('source/laravel/8.x/passwords.php'));
        $this->assertFileExists($this->tempPath('source/laravel/8.x/validation.php'));
    }

    public function testNestedPath(): void
    {
        $this->download('https://github.com/laravel/framework/archive/refs/heads/9.x.zip', 'laravel/framework', '9.x');
        $this->download('https://github.com/laravel/laravel/archive/refs/heads/9.x.zip', 'laravel/laravel', '9.x', ['lang']);

        $this->assertFileExists($this->tempPath('source/laravel/framework/9.x/framework.json'));

        $this->assertFileExists($this->tempPath('source/laravel/laravel/9.x/auth.php'));
        $this->assertFileExists($this->tempPath('source/laravel/laravel/9.x/pagination.php'));
        $this->assertFileExists($this->tempPath('source/laravel/laravel/9.x/passwords.php'));
        $this->assertFileExists($this->tempPath('source/laravel/laravel/9.x/validation.php'));
    }

    protected function download(string $url, string $project, string $version, array $copy = []): void
    {
        $this->command(Command::DOWNLOAD(), [
            Option::URL()     => $url,
            Option::PROJECT() => $project,
            Option::VERSION() => $version,
            Option::COPY()    => $copy,
        ]);
    }
}
