# G-Database ![visitors](https://visitor-badge.glitch.me/badge?page_id=DatabaseAPI)

A simple Database API for GhostlyMC Network.

Very helpful for make queries asynchronously or synchronously.

### Features

- Asynchronous queries
- Queries with callback functions
- Fast and Secure
- A good documentation

## Get Started

### Install the API
Open your CLI and execute this command:

```bash
composer require ghostlymc/g-database
```

### Using the API
#### 1 - Register the credentials for the connection.

```php
use GhostlyMC\Database\Database;

public function onLoad(): void
{
    Database::setupMySQL(
        "192.168.1.1", # HOST // REQUIRED
        "root", # USER // REQUIRED
        "zOmArRD", # PASS // REQUIRED
        "servers", # DB NAME // REQUIRED
        3306 # PORT // Optional
    );
}
```

#### 2 - Using SelectAsyncQuery.

This is an example of using the SelectAsyncQuery class.

You can actually modify this API to do queries of any kind. 

Even make your own classes to do queries. 

This is just an example of how to use the SelectAsyncQuery class.

Link to SelectAsyncQuery class: [SelectAsyncQuery](https://github.com/GhostlyMC/G-Database/blob/master/src/MySQL/Query/SelectAsyncQuery.php)

```php
use pocketmine\event\player\PlayerLoginEvent;
use GhostlyMC\Database\Database;
use GhostlyMC\Database\MySQL\Query\SelectAsyncQuery;

public function playerLoginEvent(PlayerLoginEvent $event): void
    {
        $player = $event->getPlayer();
        
        Database::getMySQL()->runQueryAsync(new SelectAsyncQuery(
            'ghostly_playerdata',
            'name',
            $player->getName(),
            function (array $data) use ($player) {
                if (count($data) === 0) {
                    $player->transfer('ghostlymc.live', 19132, 'Player is not registered!');
                } else {
                    $player->sendMessage('You are registered!');
                }
                
                $finalResult = $data[0];
                $player->setLanguage($data->language);
                $player->setScoreboard((bool)$data->scoreboard);
            },
            'DatabaseName?'
        ));
    }
```

#### 3 - Running the NotAsync Query.
If yoou want to run a query that is not asynchronous, you can use the runQuery function.

Example:
```php
use GhostlyMC\Database\Database;

public function onLoad(): void
{
    Database::getMySQL()->runQuery('SELECT * FROM ghostly_servers',
        function (array $data): void {
            foreach ($data as $row) {
                $server = new Server($row['name'], $row['ip'], (int)$row['port']);
                $this->servers[] = $server;
                Ghostly::$logger->info(sprintf("%sThe server (%s) has been loaded from the database!", PREFIX, $server->getName()));
            }
        });
    );
}
```

### WARNING

Remember that the SelectAsyncQuery class is a test class and is not guaranteed to work correctly.

This is to make it easier for you to query your database and execute callback functions.

This project is under development and is not ready to be used.

Any errors, problems, etc. please report me on GitHub.

Exclusivo uso para [GhostlyMC](https://github.com/GhostlyMC).
