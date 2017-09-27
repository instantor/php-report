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

## Installing
cmd: composer install

## Running the tests
- use InstantorDecryptExample.php as a example to receive and decrypt report
- change source and api_key variables inside InstantorDecryptExample.php according to your setup as a client

## Example of using this library inside your existing project with composer
- open composer.json
- add this line:
	"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/instantor/php-report.git"
        }
    ]
- run composer install
- make php file and use this snippet:

```php
require_once __DIR__ . '/src/Instantor/Report/Decrypt.php';
require_once __DIR__ . '/vendor/autoload.php';

use Instantor\Report\Decrypt;

$source = ""; // your product name
$api_key = ""; // your api key

$msg = Decrypt::receivePostRequest($source, $api_key, $payload);

echo $msg;

exit(0);