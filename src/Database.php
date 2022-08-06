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

namespace GhostlyMC\Database;

use GhostlyMC\Database\Exception\Exception;
use GhostlyMC\Database\MySQL\MySQL;

class Database
{

    public static MySQL $mysql;

    /**
     * First set the credentials.
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $db
     * @param int    $port
     *
     * @return void
     */
    public static function setupMySQL(
        string $host,
        string $user,
        string $pass,
        string $db,
        int $port = 3306
    ): void {
        self::$mysql = new MySQL($host, $user, $pass, $db, $port);
    }

    /**
     * @return MySQL MySQL Instance
     */
    public static function getMySQL(): MySQL
    {
        if (self::$mysql === null) {
            Exception::mysqlCredentialsException("You must register the credentials of the Database");
        }

        return self::$mysql;
    }
}