## Instantor report decryption API
Defuse encryption library is used for PHP 7 versions

## Prerequisites
- Composer 
	- install composer if not yet installed
		- Linux
			- sudo apt-get update
			- sudo apt-get install curl php5-cli git
			- curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
		- Windows
			- Download the installer file by accessing the direct download link: https://getcomposer.org/Composer-Setup.exe, or visiting the official download page: https://getcomposer.org/download/
		- OSX
			- curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

## There is two way using this library:
### 1. Example of using library as single project
- download/clone repository
- run composer install
- use InstantorDecryptExample.php as a example to receive and decrypt report
- change source and api_key variables inside InstantorDecryptExample.php according to your setup as a client
- set your endpoint URL on web server to InstantorDecryptExample.php file

### 2. Example of using library inside your existing project
- open your existing composer.json
- add this line:
	"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/instantor/php-report.git"
        }
    ],
    "require": {
        "instantor/report": "dev-master"
    }

- run composer install
- make php file and use this snippet:
```php
require_once 'vendor/autoload.php';

use Instantor\Report\Decrypt;

$source = ""; // your product name
$api_key = ""; // your api key

$msg = Decrypt::receivePostRequest($source, $api_key, $payload);

echo $msg;

exit(0);