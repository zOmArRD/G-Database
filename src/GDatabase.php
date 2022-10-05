<?php
/*
 * Created by PhpStorm.
 *
 * User: zOmArRD
 * Date: 26/7/2022
 *
 *
 *        $$$$$$\  $$\                             $$\     $$\           $$\      $$\  $$$$$$\
 *       $$  __$$\ $$ |                            $$ |    $$ |          $$$\    $$$ |$$  __$$\
 *       $$ /  \__|$$$$$$$\   $$$$$$\   $$$$$$$\ $$$$$$\   $$ |$$\   $$\ $$$$\  $$$$ |$$ /  \__|
 *       $$ |$$$$\ $$  __$$\ $$  __$$\ $$  _____|\_$$  _|  $$ |$$ |  $$ |$$\$$ $$ |$$ |
 *       $$ |\_$$ |$$ |  $$ |$$ /  $$ |\$$$$\    $$ |    $$ |$$ |  $$ |$$ \$  $$ |$$ |
 *       $$ |  $$ |$$ |  $$ |$$ |  $$ | \____$$\   $$ |$$\ $$ |$$ |  $$ |$$ |\$  /$$ |$$ |  $$\
 *       \$$$$  |$$ |  $$ |\$$$$  |$$$$$$$  |  \$$  |$$ |\$$$$$ |$$ | \_/ $$ |\$$$$  |
 *        \______/ \__|  \__| \______/ \_______/    \____/ \__| \____$$ |\__|     \__| \______/
 *                                                             $$\   $$ |
 *                                                             \$$$$  |
 *                                                              \______/
 *
 *  Copyright © 2022 GhostlyMC Network (omar@ghostlymc.live) - All Rights Reserved.
 */
declare(strict_types=1);

namespace ghostlymc\database;

use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use ghostlymc\database\mysql\MySQL;
use JetBrains\PhpStorm\ExpectedValues;

class GDatabase {

    private static ?MySQL $mysqlInstance = null;

    #[ArrayShape([
        'host' => 'string',
        'user' => 'string',
        'password' => 'string',
        'database' => 'string',
        'port' => 'int',
    ])]
    private static array $mysql_credentials = [];

    public static function setup_mysql_credentials(
        string $host,
        string $user,
        string $password,
        string $database,
        int $port = 3306
    ): void {
        self::$mysql_credentials = [
            'host' => $host,
            'user' => $user,
            'password' => $password,
            'database' => $database,
            'port' => $port,
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function get_mysql_credentials(
        #[ExpectedValues([
            'host',
            'user',
            'password',
            'database',
            'port'
        ])] string $type
    ): string|int|null {
        return match ($type) {
            'host' => self::$mysql_credentials['host'],
            'user' => self::$mysql_credentials['user'],
            'password' => self::$mysql_credentials['password'],
            'database' => self::$mysql_credentials['database'],
            'port' => self::$mysql_credentials['port'],
            default => throw new InvalidArgumentException('Invalid type'),
        };
    }

    public static function get_mysql_instance(): MySQL {
        if (self::$mysqlInstance === null) {
            self::$mysqlInstance = new MySQL();
        }

        return self::$mysqlInstance;
    }
}
