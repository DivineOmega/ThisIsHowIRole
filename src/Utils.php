<?php

namespace DivineOmega\ThisIsHowIRole;

abstract class Utils
{
    private static $testMode = null;

    public static function enableTestMode()
    {
        self::$testMode = true;
    }

    public static function disableTestMode()
    {
        self::$testMode = false;
    }

    public static function testModeActive()
    {
        return self::$testMode;
    }
}