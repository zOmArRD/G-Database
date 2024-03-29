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

namespace ghostlymc\database\mysql;

use Closure;
use pocketmine\Server;
use ghostlymc\database\mysql\query\AsyncQuery;
use ghostlymc\database\mysql\query\SelectQuery;

class MySQL {
    private string $dbName;

    /**
     * Do you want to change the database?
     *
     * @param string $database
     *
     * @return void
     */
    public function updateDatabase(string $database): void {
        $this->dbName = $database;
    }

    /**
     * @return string
     */
    public function getDatabase(): string {
        return $this->dbName;
    }

    /**
     * @param AsyncQuery $query
     *
     * @return void
     */
    public function runAsyncQuery(AsyncQuery $query): void {
        Server::getInstance()->getAsyncPool()->submitTask($query);
    }

    /**
     * @see https://github.com/GhostlyMC/G-Database/tree/master
     *
     * @param string $table
     * @param string|null $key
     * @param string|null $value
     * @param Closure|null $closure
     * @param string|null $dbName
     *
     * @return void
     */
    public function runSelectQuery(
        string   $table,
        ?string  $key = null,
        ?string  $value = null,
        ?Closure $closure = null,
        ?string  $dbName = null
    ): void {
        new SelectQuery($table, $key, $value, $closure, $dbName);
    }
}