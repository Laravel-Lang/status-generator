<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Packages;

use LaravelLang\StatusGenerator\Services\Packages\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    protected array $files = [];

    public function testParsesTranslationKeys(): void
    {
        $path = $this->makeFile(<<<'PHP'
            <?php

            __('Plain text');
            __("Double quoted text");
            __('You\'re invited');
            PHP);

        $this->assertSame([
            'Plain text'         => 'Plain text',
            'Double quoted text' => 'Double quoted text',
            "You're invited"     => "You're invited",
        ], Parser::make()->files([$path])->get());
    }

    public function testParsesTranslationKeyEndingWithEscapedDoubleQuote(): void
    {
        $path = $this->makeFile(<<<'PHP'
            <?php

            Flux::toast(variant: 'success', text: __('You left the team \":name\"', ['name' => $team->name]));
            PHP);

        $this->assertSame([
            'You left the team ":name"' => 'You left the team ":name"',
        ], Parser::make()->files([$path])->get());
    }

    protected function makeFile(string $content): string
    {
        $path = tempnam(sys_get_temp_dir(), 'status-generator-parser-');

        file_put_contents($path, $content);

        $this->files[] = $path;

        return $path;
    }

    protected function tearDown(): void
    {
        foreach ($this->files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        parent::tearDown();
    }
}
