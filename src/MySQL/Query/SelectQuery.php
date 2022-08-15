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

namespace GhostlyMC\Database\MySQL\Query;

use mysqli;
use Closure;
use mysqli_result;
use GhostlyMC\Database\Database;

class SelectQuery {
    public function __construct(
        private string   $table,
        private ?string  $key = null,
        private ?string  $value = null,
        private ?Closure $closure = null,
        private ?string  $dbName = null
    ) {
        if ($dbName === null)
            $this->dbName = Database::getMySQL()->getDatabase();

        $this->query(
            new mysqli(
                Database::getMySQL()->getHost(),
                Database::getMySQL()->getUser(),
                Database::getMySQL()->getPassword(),
                $this->dbName,
                Database::getMySQL()->getPort()
            )
        );
    }

    /**
     * @todo Check Unnecessary curly braces.
     */
    public function query(mysqli $mysqli): void {
        if (!isset($this->key)) $result = $mysqli->query("SELECT * FROM {$this->table}"); else {
            $result = $mysqli->query("SELECT * FROM {$this->table} WHERE {$this->key} = {$this->value}");
        }

        if (!$result instanceof mysqli_result):
            $this->closure->__invoke();
        else:
            $rows = [];

            while ($row = $result->fetch_assoc()) $rows[] = $row;

            $this->closure->__invoke($rows);
        endif;
    }
}