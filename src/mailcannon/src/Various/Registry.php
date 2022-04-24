<?php

namespace MailCannon\Various;


class Registry
{

    private static string $config_file = __DIR__ . "/../../../config.json";

    private static array $config;
    private static ManagerFactory $manager_factory;
    private static Db $db;

    public static getConfig()
    {

        if(empty(self::$config))
            self::$config = json_decode(file_get_contents(self::$config_file), 1);

        return self::$config;
    }


    public static getManagerFactory()
    {

        if(empty(self::$manager_factory))
            self::$manager_factory = new ManagerFactory();

        return self::$manager_factory;
    }


    public static getDb()
    {

        if(empty(self::$db))
            self::$db = new Db();

        return self::$db;
    }
}