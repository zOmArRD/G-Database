<?php
/*
 * Created by PhpStorm.
 *
 * User: zOmArRD
 * Date: 6/8/2022
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

namespace ghostlymc\database\mysql\query;

use mysqli;
use Closure;
use mysqli_result;
use ghostlymc\database\GDatabase;


class SelectQuery {

    /** @noinspection CallableParameterUseCaseInTypeContextInspection */
    public function __construct(
        private string   $table,
        private ?string  $key = null,
        private ?string  $value = null,
        private ?Closure $closure = null,
        ?string          $dbName = null
    ) {
        if ($dbName === null) {
            $dbName = GDatabase::get_mysql_credentials('database');
        }

        $this->query(
            new mysqli(
                GDatabase::get_mysql_credentials('host'),
                GDatabase::get_mysql_credentials('user'),
                GDatabase::get_mysql_credentials('password'),
                $dbName,
                GDatabase::get_mysql_credentials('port')
            )
        );
    }

    /**
     * @todo Check Unnecessary curly braces.
     */
    public function query(mysqli $mysqli): void {
        if (!isset($this->key)) {
            $result = $mysqli->query("SELECT * FROM {$this->table}");
        } else {
            $result = $mysqli->query("SELECT * FROM {$this->table} WHERE {$this->key} = {$this->value}");
        }

        if (!$result instanceof mysqli_result):
            $this->closure->__invoke();
        else:
            $rows = [];

            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            $this->closure->__invoke($rows);
        endif;
    }
}