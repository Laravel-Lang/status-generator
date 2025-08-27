<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Upgrade;

class SourceTest extends Base
{
    public function testFramework(): void
    {
        $this->assertJsonFileEqualsJson([
            'All rights reserved.' => 'All rights reserved.',
            'API Token'            => 'API Token',
            'Forbidden'            => 'Forbidden',
            'Go to page :page'     => 'Go to page :page',
            'ID'                   => 'ID',
        ], 'source/packages/framework/laravel-9.json', __FUNCTION__);
    }

    public function testUi(): void
    {
        $this->assertJsonFileEqualsJson([
            'A fresh verification link has been sent to your email address.'      => 'A fresh verification link has been sent to your email address.',
            'Before proceeding, please check your email for a verification link.' => 'Before proceeding, please check your email for a verification link.',
        ], 'source/packages/ui.json', __FUNCTION__);
    }

    public function testAuth(): void
    {
        $this->assertJsonFileEqualsJson([
            'failed'   => 'These credentials do not match our records.',
            'password' => 'The provided password is incorrect.',
            'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
        ], 'source/auth.php', __FUNCTION__);
    }

    public function testPagination(): void
    {
        $this->assertJsonFileEqualsJson([
            'previous' => '&laquo; Previous',
            'next'     => 'Next &raquo;',
        ], 'source/pagination.php', __FUNCTION__);
    }

    public function testPasswords(): void
    {
        $this->assertJsonFileEqualsJson([
            'reset' => 'Your password has been reset!',
            'sent'  => 'We have emailed your password reset link!',
        ], 'source/passwords.php', __FUNCTION__);
    }

    public function testValidation(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'    => 'The :attribute must be accepted.',
            'accepted_if' => 'The :attribute must be accepted when :other is :value.',
            'active_url'  => 'The :attribute is not a valid URL.',

            'between' => [
                'array' => 'The :attribute must have between :min and :max items.',
                'file'  => 'The :attribute must be between :min and :max kilobytes.',
            ],
        ], 'source/validation.php', __FUNCTION__);
    }

    public function testValidationInline(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'    => 'This field must be accepted.',
            'accepted_if' => 'This field must be accepted when :other is :value.',
            'active_url'  => 'This is not a valid URL.',

            'between' => [
                'array' => 'This content must have between :min and :max items.',
                'file'  => 'This file must be between :min and :max kilobytes.',
            ],
        ], 'source/validation-inline.php', __FUNCTION__);
    }
}
