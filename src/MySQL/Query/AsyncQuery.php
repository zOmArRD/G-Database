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

namespace GhostlyMC\Database\MySQL\Query;

use mysqli;
use Closure;
use GhostlyMC\Database\GDatabase;
use pocketmine\scheduler\AsyncTask;
use GhostlyMC\Database\Exception\Exception;

abstract class AsyncQuery extends AsyncTask {
    public ?Closure $closure;
    public string $dbName;

    public function __construct(
        ?Closure $closure = null,
        ?string  $dbName = null
    ) {
        $this->closure = $closure;
        $this->dbName = $dbName === null ? GDatabase::get_mysql_credentials('database') : $dbName;
    }

    /**
     * @return Closure|null
     */
    public function getClosure(): ?Closure {
        return $this->closure;
    }

    public function onRun(): void {
        $query = new mysqli(
            GDatabase::get_mysql_credentials('host'),
            GDatabase::get_mysql_credentials('user'),
            GDatabase::get_mysql_credentials('password'),
            $this->dbName,
            GDatabase::get_mysql_credentials('port')
        );

        if ($query->connect_error)
            throw Exception::mysqlConnectionException("MySQL connection failed: $query->connect_error");

        $this->query($query);
        $query->close();
    }

    /**
     * Make the query to the database.
     *
     * @param mysqli $mysqli
     *
     * @return void
     */
    abstract public function query(mysqli $mysqli): void;
}