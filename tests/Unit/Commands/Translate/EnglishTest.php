<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Translate;

class EnglishTest extends Base
{
    public function testJson(): void
    {
        $this->assertJsonFileEqualsJson([
            'Added.'        => 'Added.',
            'Administrator' => 'Administrator',
        ], 'locales/en/json.json', __FUNCTION__);
    }

    public function testPhp(): void
    {
        $this->assertJsonFileEqualsJson([
            '0'             => 'Numeric Zero',
            '10'            => 'Numeric Ten',
            '100'           => 'Numeric One Hundred',
            'accepted'      => 'The :attribute must be accepted.',
            'accepted_if'   => 'The :attribute must be accepted when :other is :value.',
            'active_url'    => 'The :attribute is not a valid URL.',
            'between.array' => 'The :attribute must have between :min and :max items.',
            'between.file'  => 'The :attribute must be between :min and :max kilobytes.',
        ], 'locales/en/php.json', __FUNCTION__);
    }

    public function testPhpInline(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'      => 'This field must be accepted.',
            'accepted_if'   => 'This field must be accepted when :other is :value.',
            'active_url'    => 'This field is not a valid URL.',
            'between.array' => 'This field must have between :min and :max items.',
            'between.file'  => 'This field must be between :min and :max kilobytes.',
        ], 'locales/en/php-inline.json', __FUNCTION__);
    }

    public function testExcludes(): void
    {
        $this->assertFileDoesNotExist($this->tempPath('locales/en/_excludes.json'));
    }
}
