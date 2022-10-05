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
use GhostlyMC\Database\GDatabase;

public function onLoad(): void {
    GDatabase::setup_mysql_credentials($host, $user, $password, $database);
}
```

#### 2 - Using SelectAsyncQuery.

This is an example of using the SelectAsyncQuery class.

You can actually modify this API to do queries of any kind.

Even make your own classes to do queries.

This is just an example of how to use the SelectAsyncQuery class.

Link to SelectAsyncQuery
class: [SelectAsyncQuery](https://github.com/GhostlyMC/G-Database/blob/master/src/MySQL/Query/SelectAsyncQuery.php)

```php
use GhostlyMC\Database\GDatabase;use pocketmine\event\player\PlayerLoginEvent;use ghostlymc\database\mysql\query\SelectAsyncQuery;

public function playerLoginEvent(PlayerLoginEvent $event): void {
    $player = $event->getPlayer();
    
    $MySQL = GDatabase::get_mysql_instance();
    
    $MySQL->runAsyncQuery(new SelectAsyncQuery(
        table: 'ghostly_playerData',
        key: 'playerName',
        value: $player->getName(),
        closure: function(array $data) use ($player) {
                    if (count($data) === 0) {
                        $player->transfer('ghostlymc.live', 19132, 'Player is not registered!');
                    } else {
                        $player->sendMessage('You are registered!');
                    }
                
                $finalResult = $data[0];
                $player->setLanguage($finalResult->language);
                $player->setScoreboard((bool)$finalResult->scoreboard);
        },dbName: 'optional' # It is not necessary if you do not want to do it in another Database.
    ));
}
```

#### 3 - Running the NotAsync Query.

If you want to run a query that is not asynchronous, you can use the runQuery function.

Example:

```php
use GhostlyMC\Database\GDatabase;

public function onLoad(): void
{
    GDatabase::get_mysql_instance()->runSelectQuery(
    table: 'ghostlymc_servers', 
    key: null /** Not Necessary */, 
    value: null /** Not Necessary */,
    closure: function(array $data) {
        foreach ($data as $row) {
            $this->server[] = new Server($row['name'], $row['ip'], (int)$row['port']);
            
            Ghostly::$logger->info(
                sprintf("%sThe server (%s) has been loaded from the database!", 
                PREFIX, 
                $server->getName())
            );
        }
    }, dbName: 'Optional');
}
```

### WARNING

Remember that the SelectAsyncQuery class is a test class and is not guaranteed to work correctly.

This is to make it easier for you to query your database and execute callback functions.

This project is under development and is not ready to be used.

Any errors, problems, etc. please report me on GitHub.

Exclusive for [GhostlyMC](https://github.com/GhostlyMC).
