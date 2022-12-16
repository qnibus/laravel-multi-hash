# LaravelJasyptHash
## Requirement
- laravel 9.x or later
- php 8.x

## Usage
1. Input your command line in below command.
    ```bash
    composer require qnibus/laravel-jasypt-hash
    ```
     
2. Open `/config/hashing.php` in your laravel application and modify.
    ```php
    'driver' => 'jasypt',
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