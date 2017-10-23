<?php

namespace DivineOmega\ThisIsHowIRole;

use DivineOmega\ThisIsHowIRole\DatabaseHelper;


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

    public static function getIdsByRole($className,$role)
    {
        $database = DatabaseHelper::getDatabaseDriver();

       $ids =  $database->getAllByRole($className,$role);

       return $ids;
    }
}