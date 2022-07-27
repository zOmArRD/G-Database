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

use GhostlyMC\Database\Database;
use GhostlyMC\Database\Exception\Exception;
use pocketmine\scheduler\AsyncTask;

abstract class AsyncQuery extends AsyncTask
{
    public function __construct(
        private string $database
    ) {
        if (!Database::getMySQL()->isCredentialsSet()) {
            Exception::mysqlCredentialsException("No credentials set for MySQL!");
        }
    }

    public function onRun(): void
    {
        $query = new \mysqli(
            Database::getMySQL()->getHost(),
            Database::getMySQL()->getUser(),
            Database::getMySQL()->getPassword(),
            $this->database
        );

        if ($query->connect_error) {
            Exception::mysqlCredentialsException("MySQL connection failed: " . $query->connect_error);
        }

        $this->query($query);
        $query->close();
    }

    abstract public function query(\mysqli $mysqli): void;

    public function onCompletion(): void {
        //TODO: Execute CallBack
    }
}