<?php

namespace Tests\Unit\Commands\Upgrade;

class AfrikaansTest extends Base
{
    public function testExcludes(): void
    {
        $this->assertJsonFileEqualsJson([
            'API Token',
            'ID',
        ], 'locales/af/_excludes.json', __FUNCTION__);
    }

    public function testJson(): void
    {
        $this->assertJsonFileEqualsJson([
            'A fresh verification link has been sent to your email address.' => 'A fresh verification link has been sent to your email address.',

            'All rights reserved.' => 'Alle regte voorbehou.',
            'API Token'            => 'API Token',

            'Before proceeding, please check your email for a verification link.' => 'Before proceeding, please check your email for a verification link.',

            'Forbidden'        => 'Prohibido',
            'Go to page :page' => 'Gaan na bladsy :page',

            'ID' => 'ID',
        ], 'locales/af/json.json', __FUNCTION__);
    }

    public function testPhp(): void
    {
        $this->assertJsonFileEqualsJson([
            '0'             => 'Numeriese nul',
            '10'            => 'Numeriese Tien',
            '100'           => 'Numeriese honderd',
            'accepted'      => 'Die :attribute moet aanvaar word.',
            'accepted_if'   => 'The :attribute must be accepted when :other is :value.',
            'active_url'    => 'Die :attribute is nie \'n geldig URL.',
            'attached'      => 'Hierdie :attribute is reeds aangeheg.',
            'between.array' => 'Die :attribute moet tussen :min en :max items hê.',
            'between.file'  => 'Die :attribute moet tussen :min en :max kilobytes wees.',
            'failed'        => 'Hierdie verwysings stem nie ooreen met ons rekords nie.',
            'next'          => 'Volgende &raquo;',
            'password'      => 'Die ingevoerde wagwoord is nie korrek nie.',
            'previous'      => '&laquo; Vorige',
            'relatable'     => 'Hierdie :attribute kan nie wees wat verband hou met hierdie hulpbron.',
            'reset'         => 'U wagwoord is verstel!',
            'sent'          => 'Ons het u skakel vir die herstel van wagwoord per e-pos gestuur!',
            'throttle'      => 'Te veel pogings om aan te meld. Probeer asseblief weer binne :seconds sekondes',
        ], 'locales/af/php.json', __FUNCTION__);
    }

    public function testPhpInline(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'      => 'Hierdie veld moet aanvaar word.',
            'accepted_if'   => 'This field must be accepted when :other is :value.',
            'active_url'    => 'Hierdie is nie geldige URL.',
            'attached'      => 'Hierdie veld is reeds aangeheg.',
            'between.array' => 'Hierdie inhoud moet tussen :min en :max items bevat.',
            'between.file'  => 'Hierdie lêer moet tussen :min en :max kilobytes wees.',
            'relatable'     => 'Hierdie veld kan nie wees wat verband hou met hierdie hulpbron.',
        ], 'locales/af/php-inline.json', __FUNCTION__);
    }
}
