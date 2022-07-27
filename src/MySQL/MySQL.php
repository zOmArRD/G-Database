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

use GhostlyMC\Database\MySQL\Query\AsyncQuery;
use pocketmine\Server;

class MySQL
{
    private ?string $host, $port, $user, $password;

    /**
     * You must first execute this
     * function to execute the queries.
     *
     * @param string $host     MySQL Host
     * @param string $port     MySQL Port
     * @param string $user     MySQL User
     * @param string $password MySQL Password
     *
     * @return void
     */
    public function saveCredentials(string $host, string $port, string $user, string $password): void
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @return string Host
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string Port
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @return string User
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string Password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * This verifies that the credentials are set.
     *
     * @return bool
     */
    public function isCredentialsSet(): bool
    {
        return $this->host !== null && $this->port !== null && $this->user !== null && $this->password !== null;
    }

    private static array $callbacks = [];

    /**
     * @param AsyncQuery    $query
     * @param callable|null $callable
     * @param string|null   $database
     *
     * @return void
     */
    public function runAsync(AsyncQuery $query, ?callable $callable = null, ?string $database = null): void
    {

        Server::getInstance()->getAsyncPool()->submitTask($query);
    }

    /**
     * Run the callable when the query is finished.
     *
     * @param AsyncQuery $query
     *
     * @return void
     */
    public function executeCallback(AsyncQuery $query): void
    {
        //TODO
    }
}