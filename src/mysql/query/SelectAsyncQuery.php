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

class SelectAsyncQuery extends AsyncQuery {
    public mixed $rows;

    /**
     * @param string $table Database table to select from
     * @param string|null $key Database table key to select from
     * @param string|null $value Database table value to select from
     * @param Closure|null $closure Closure to execute on query
     * @param string|null $dbName Database name to select from
     */
    public function __construct(
        private string  $table,
        private ?string $key = null,
        private ?string $value = null,
        ?Closure        $closure = null,
        ?string         $dbName = null
    ) {
        parent::__construct($closure, $dbName);
    }

    public function query(mysqli $mysqli): void {
        $result = !isset($this->key) ? $mysqli->query("SELECT * FROM $this->table") : $mysqli->query("SELECT * FROM $this->table WHERE $this->key = $this->value");

        if ($result instanceof mysqli_result):
            $rows = [];

            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            $this->rows = serialize($rows);
        endif;
    }

    /** @noinspection UnserializeExploitsInspection */
    public function onCompletion(): void {
        if ($this->rows !== null) {
            $this->closure->__invoke(unserialize($this->rows));
        } else {
            $this->closure->__invoke();
        }
    }
}