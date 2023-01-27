# LaravelMultiHash
## Requirement
- laravel 9.x or later
- php 8.x

## Usage
1. Input your command line in below command.
    ```bash
    composer require qnibus/laravel-multi-hash
    ```
     
2. Open `/config/hashing.php` in your laravel application and modify.
    ```php
    'driver' => 'jasypt',// 'md5', 'sha256', 'sha512' or 'jasypt'
    ```
3. Your code anywhere...
    ```php
    # make hash
    Hash::make('some string');
    // result: NDM1M2M0ZmQ3MWYzNmJiZIXQlXLOzKcLkUKAZ6p6NPBBDA0zGwVCDkFuLmvbeozd
    
    # check hash
    Hash::check('some string', 'NDM1M2M0ZmQ3MWYzNmJiZIXQlXLOzKcLkUKAZ6p6NPBBDA0zGwVCDkFuLmvbeozd');
    // result: true
    ```
4. Publish package config to config directory in laravel.
    ```bash
    php artisan vendor:publish --tag=multi-hashing-config
    ```
5. Modify option in `/config/multi-hashing.php`

## Better use
```php
# Usage for jasypt
Hash::driver('jasypt')->make('some string');
Hash::driver('jasypt')->check('some string', $hashedString);

# Usage for sha256
Hash::driver('sha256')->make('some string');
Hash::driver('sha256')->check('some string', $hashedString);

# Usage for sha512
Hash::driver('sha512')->make('some string');
Hash::driver('sha512')->check('some string', $hashedString);

# Usage for md5
Hash::driver('md5')->make('some string');
Hash::driver('md5')->check('some string', $hashedString);
```
