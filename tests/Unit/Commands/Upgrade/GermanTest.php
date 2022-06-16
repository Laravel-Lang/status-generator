<?php

namespace Tests\Unit\Commands\Upgrade;

class GermanTest extends Base
{
    public function testExcludes(): void
    {
        $this->assertJsonFileEqualsJson([
            'Administrator',
            'ID',
        ], 'locales/de/_excludes.json', __FUNCTION__);
    }

    public function testJson(): void
    {
        $this->assertJsonFileEqualsJson([
            'A fresh verification link has been sent to your email address.' => 'Ein neuer Bestätigungslink wurde an Ihre E-Mail-Adresse gesendet.',

            'All rights reserved.' => 'Alle Rechte vorbehalten.',
            'API Token'            => 'API-Token',

            'Before proceeding, please check your email for a verification link.' => 'Bevor Sie fortfahren, überprüfen Sie bitte Ihre E-Mail auf einen Bestätigungslink.',

            'Forbidden'        => 'Verboten',
            'Go to page :page' => 'Gehe zur Seite :page',

            'ID' => 'ID',
        ], 'locales/de/json.json', __FUNCTION__);
    }

    public function testPhp(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'      => ':attribute muss akzeptiert werden.',
            'accepted_if'   => ':attribute muss akzeptiert werden, wenn :other :value ist.',
            'active_url'    => ':attribute ist keine gültige Internet-Adresse.',
            'attached'      => ':attribute ist bereits angehängt.',
            'between.array' => ':attribute muss zwischen :min & :max Elemente haben.',
            'between.file'  => ':attribute muss zwischen :min & :max Kilobytes groß sein.',
            'failed'        => 'Diese Kombination aus Zugangsdaten wurde nicht in unserer Datenbank gefunden.',
            'next'          => 'Weiter &raquo;',
            'password'      => 'Das eingegebene Passwort ist nicht korrekt.',
            'previous'      => '&laquo; Zurück',
            'relatable'     => ':attribute kann nicht mit dieser Ressource verbunden werden.',
            'reset'         => 'Das Passwort wurde zurückgesetzt!',
            'sent'          => 'Passworterinnerung wurde gesendet!',
            'throttle'      => 'Zu viele Loginversuche. Versuchen Sie es bitte in :seconds Sekunden nochmal.',
        ], 'locales/de/php.json', __FUNCTION__);
    }

    public function testPhpInline(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'      => 'Dieses Feld muss akzeptiert werden.',
            'accepted_if'   => 'Dieses Feld muss akzeptiert werden, wenn :other :value ist.',
            'active_url'    => 'Das ist keine gültige Internet-Adresse.',
            'attached'      => 'Dieses Feld ist bereits angehängt.',
            'between.array' => 'Dieser Inhalt muss zwischen :min & :max Elemente haben.',
            'between.file'  => 'Diese Datei muss zwischen :min & :max Kilobytes groß sein.',
            'relatable'     => 'Das kann nicht mit dieser Ressource verbunden werden.',
        ], 'locales/de/php-inline.json', __FUNCTION__);
    }
}
