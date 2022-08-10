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

use Closure;
use mysqli;
use mysqli_result;

class SelectAsyncQuery extends AsyncQuery
{
    public mixed $rows;

    public function __construct(
        private string $table,
        private ?string $key = null,
        private ?string $value = null,
        ?Closure $closure = null,
        ?string $dbName = null
    ) { parent::__construct($closure, $dbName); }

    public function query(mysqli $mysqli): void
    {
        if (!isset($this->key)) {
            $result = $mysqli->query("SELECT * FROM {$this->table}");
        } else {
            $result = $mysqli->query("SELECT * FROM {$this->table} WHERE {$this->key} = {$this->value}");
        }

        $rows = [];

        if ($result instanceof mysqli_result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        $this->rows = serialize($rows);
    }

    public function onCompletion(): void
    {
        if ($this->rows !== null) {
            $this->closure->__invoke(unserialize($this->rows));
        } else {
            $this->closure->__invoke(null);
        }
    }
}