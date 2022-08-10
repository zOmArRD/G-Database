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

namespace GhostlyMC\Database\MySQL;

use Closure;
use GhostlyMC\Database\MySQL\Query\AsyncQuery;
use GhostlyMC\Database\MySQL\Query\SelectQuery;
use pocketmine\Server;

class MySQL
{
    public function __construct(
        private string $host,
        private string $user,
        private string $password,
        private string $database,
        private int    $port = 3306,
    ) {}

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Do you want to change the database?
     *
     * @param string $database
     *
     * @return void
     */
    public function updateDatabase(string $database): void
    {
        $this->database = $database;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param AsyncQuery $query
     *
     * @return void
     */
    public function runQueryAsync(AsyncQuery $query): void
    {
        Server::getInstance()->getAsyncPool()->submitTask($query);
    }

    /**
     * @see https://github.com/GhostlyMC/G-Database/tree/master
     *
     * @param string       $table
     * @param string|null  $key
     * @param string|null  $value
     * @param Closure|null $closure
     * @param string|null  $dbName
     *
     * @return void
     */
    public function runSelectQuery(
        string   $table,
        ?string  $key = null,
        ?string  $value = null,
        ?Closure $closure = null,
        ?string  $dbName = null
    ): void
    {
        new SelectQuery($table, $key, $value, $closure, $dbName);
    }
}