<?php
declare (strict_types=1);

class Singleton {
    private function __construct() { } //Object cannot be created.
    /** @var Singleton */ private static $singletonObject = null;
    static function getInstance() : Singleton {
        if (self::$singletonObject === null)
            self::createSingleton();
        return self::$singletonObject;
    }
    private static function createSingleton(): void {
        self::$singletonObject = new Singleton();
        //This function is not thread-safe.
    }
    private function __clone() {} //cloning disabled
    private function __sleep() {} //serialize disabled
    private function __wakeup() {} //deserialize disabled
    function process() : void {
        printf("Singleton used\n");
    }
}
