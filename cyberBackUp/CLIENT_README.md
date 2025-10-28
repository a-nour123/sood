# GRC (Governance, Risk, and Compliance) Client

## Prerequisites
* extension=php_ldap.dll (Using Apache Server: Search for extension=php_ldap.dll or extension=ldap in php.ini file. Uncomment this line, if not present then add this line in the file and save the file. Then restart your server)

* extension=/your-absolute-path/bolt.so [Download](https://phpbolt.com/download-phpbolt/) or use it here `Extensions/phpBolt-extension-1.0.4.zip`

## Get the version
1. Database 

    2.1 in `database/seeders/DatabaseSeeder.php` set `SEEDING_MODE` constant to be production

    2.2 in `database/seeders/DatabaseSeeder.php` via `SEEDING_FRAMEWORKS` constant comment frameworks you don't want in this constant array

    2.3 Migrate & seed
    ``` 
        php artisan migrate:fresh --seed
    ```
    2.4 Export the database
2. Code

    Note: Make sure that you are on the correct branch
    
    1. Copy the project
    2. composer require --dev sbamtr/laravel-source-encrypter [Laravel-Source-Encrypter repository](https://github.com/SiavashBamshadnia/Laravel-Source-Encrypter)
    3. 
        * Remove routes/website.php file
        * Remove 
        ```
            Route::middleware(['web'])
                ->namespace($this->namespace)
                ->group(base_path('routes/website.php'));
        ```
        from app\Providers\RouteServiceProvider.php
        * Add
        ``` Route::redirect('/', '/admin');```
        under
        ``` Route::group(['middleware' => ['auth']], function () { ``` in routes/web.php

    4. rm -rf .git*
    5. php artisan encrypt-source
    6. rm -r database docker Extensions __OOAD tests app routes .idea .vs
    7. mv encrypted/app app
    8. mv encrypted/routes routes
    9. rm -r encrypted
    10. rm CLIENT_README.md docker-compose.yml LICENSE package.json package-lock.json README.md SERIAL_README.md .editorconfig .env
    11. mv .env.example .env

3. Licence Key
    
    Via Terminal
    ```
        echo -n "cyber-mode" > vendor/laravel/framework/src/Illuminate/Encryption/t
        echo -n "cyber-mode" > vendor/laravel/framework/src/Illuminate/Encryption/ed
        echo -n "cyber-mode" > vendor/laravel/framework/src/Illuminate/Encryption/am
    ```
    Create a company in GRC management then you will get the application key and use it to set APP_KEY in .env
    
    Create a license key in GRC management then you will get a validation code and use it to activate the software
    
---
## License
GRC application Copyright © 2022-2023 PK company.
