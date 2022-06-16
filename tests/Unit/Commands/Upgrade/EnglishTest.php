<?php

namespace Tests\Unit\Commands\Upgrade;

class EnglishTest extends Base
{
    public function testExcludes(): void
    {
        $this->assertFileDoesNotExist($this->tempPath('locales/en/_excludes.json'));
    }

    public function testJson(): void
    {
        $this->assertJsonFileEqualsJson([
            'A fresh verification link has been sent to your email address.' => 'A fresh verification link has been sent to your email address.',

            'All rights reserved.' => 'All rights reserved.',
            'API Token'            => 'API Token',

            'Before proceeding, please check your email for a verification link.' => 'Before proceeding, please check your email for a verification link.',

            'Forbidden'        => 'Forbidden',
            'Go to page :page' => 'Go to page :page',

            'ID' => 'ID',
        ], 'locales/en/json.json', __FUNCTION__);
    }

    public function testPhp(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'      => 'The :attribute must be accepted.',
            'accepted_if'   => 'The :attribute must be accepted when :other is :value.',
            'active_url'    => 'The :attribute is not a valid URL.',
            'between.array' => 'The :attribute must have between :min and :max items.',
            'between.file'  => 'The :attribute must be between :min and :max kilobytes.',
            'failed'        => 'These credentials do not match our records.',
            'next'          => 'Next &raquo;',
            'password'      => 'The provided password is incorrect.',
            'previous'      => '&laquo; Previous',
            'reset'         => 'Your password has been reset!',
            'sent'          => 'We have emailed your password reset link!',
            'throttle'      => 'Too many login attempts. Please try again in :seconds seconds.',
        ], 'locales/en/php.json', __FUNCTION__);
    }

    public function testPhpInline(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'      => 'This field must be accepted.',
            'accepted_if'   => 'This field must be accepted when :other is :value.',
            'active_url'    => 'This is not a valid URL.',
            'between.array' => 'This content must have between :min and :max items.',
            'between.file'  => 'This file must be between :min and :max kilobytes.',
        ], 'locales/en/php-inline.json', __FUNCTION__);
    }
}
