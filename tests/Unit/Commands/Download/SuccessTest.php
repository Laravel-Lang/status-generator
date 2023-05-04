<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Download;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
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

    public function testDifferentDirectoryName(): void
    {
        $this->download('https://github.com/laravel/spark-aurelius-mollie/archive/refs/heads/v2.zip', 'spark', 'v2', ['install-stubs/resources/lang']);

        $this->assertFileExists($this->tempPath('source/spark/v2/spark.json'));

        $this->assertFileExists($this->tempPath('source/spark/v2/teams.php'));
        $this->assertFileExists($this->tempPath('source/spark/v2/validation.php'));
    }

    public function testOnlyCopy(): void
    {
        $this->download('https://github.com/laravel/spark-aurelius/archive/refs/heads/12.x.zip', 'spark', 'v2', ['install-stubs/resources/lang'], true);

        $this->assertFileExists($this->tempPath('source/spark/v2/en.json'));

        $this->assertFileExists($this->tempPath('source/spark/v2/teams.php'));
        $this->assertFileExists($this->tempPath('source/spark/v2/validation.php'));
    }

    public function testSameNameFiles(): void
    {
        $this->download('https://github.com/laravel/nova-dusk-suite/archive/refs/heads/master.zip', 'nds', 'master', ['lang', 'lang/vendor/nova']);

        $this->assertFileExists($this->tempPath('source/nds/master/en.json'));

        $content = Arr::ofFile($this->tempPath('source/nds/master/en.json'));

        $this->assertTrue($content->exists('The :attribute must contain at least one letter.'));
        $this->assertTrue($content->exists('The :attribute must contain at least one number.'));

        $this->assertTrue($content->exists('Actions'));
        $this->assertTrue($content->exists('Details'));
        $this->assertTrue($content->exists('Dashboard'));
    }

    public function testPhpTranslations(): void
    {
        $this->download('https://github.com/filamentphp/filament/archive/refs/heads/2.x.zip', 'filament', '2.x', ['packages/admin/resources/lang']);

        $this->assertFileExists($this->tempPath('source/filament/2.x/filament.json'));

        $this->assertFileExists($this->tempPath('source/filament/2.x/account-widget.php'));
        $this->assertFileExists($this->tempPath('source/filament/2.x/create-record.php'));
        $this->assertFileExists($this->tempPath('source/filament/2.x/dashboard.php'));
        $this->assertFileExists($this->tempPath('source/filament/2.x/edit-record.php'));
        $this->assertFileExists($this->tempPath('source/filament/2.x/filament-info-widget.php'));
        $this->assertFileExists($this->tempPath('source/filament/2.x/global-search.php'));
        $this->assertFileExists($this->tempPath('source/filament/2.x/layout.php'));
        $this->assertFileExists($this->tempPath('source/filament/2.x/list-records.php'));
        $this->assertFileExists($this->tempPath('source/filament/2.x/login.php'));
        $this->assertFileExists($this->tempPath('source/filament/2.x/view-record.php'));

        $content = file_get_contents($this->tempPath('source/filament/2.x/filament.json'));

        $this->assertFalse(Str::contains($content, [
            'filament-spatie-laravel-settings-plugin::',
            'filament-support::',
            'filament::',
            'forms::',
            'notifications::',
            'tables::',
        ]));
    }

    protected function download(string $url, string $project, string $version, array $copy = [], bool $only_copy = false): void
    {
        $this->command(Command::DOWNLOAD, [
            Option::URL()       => $url,
            Option::PROJECT()   => $project,
            Option::VERSION()   => $version,
            Option::COPY()      => $copy,
            Option::ONLY_COPY() => $only_copy,
        ]);
    }
}
