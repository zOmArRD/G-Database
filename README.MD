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

#### 2 - Make a query.

```php
use GhostlyMC\Database\Database;


```
