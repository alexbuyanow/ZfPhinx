# ZfPhinx

ZF3 module, integrated [Phinx](https://github.com/robmorgan/phinx)

[Phinx](https://phinx.org/) is easy database migration manager

## Dependencies

+ [PHP >= 5.6](https://php.net)
+ [Zend Framework >= 3](http://framework.zend.com/),
+ [Phinx >= 0.6.0](https://phinx.org/),

## Installation

1. Install Composer:

```
    curl -sS https://getcomposer.org/installer | php
```

1. Require ZfPhinx as a dependency using Composer:

```
    php composer.phar require alexbuyanow/zfphinx
```

1. Install Phinx:

```
    php composer.phar install
```

1. Open my/project/directory/configs/application.config.php and add the following key to your modules:

```
    'ZfPhinx',
```

## Configuration

Configure 'zfphinx' section in your application config

```
    'zfphinx' => [
        'paths' => [
            'migrations' => '<path to your migration directory>',
            'seeds'      => '<path to your seed directory>',
        ],
    
        'environments' => [
            'default_migration_table' => '<DB table for migrations journal. Default is phinxlog>',
            'default_database'        => '<Unnecessary default environment key>',
            '<environment key 1>'     => [
                'db_adapter' => '<DB adapter name from service locator>',
            ],
            ...
            '<environment key n>'     => [
                'db_adapter' => '<DB adapter name from service locator>',
            ],
        ],
    ],
```

## Usage

Basic usage via console (from your project root)

```
    php public/index.php zfphinx <command> <flags>
```

List of available commands
 
 ```
     php public/index.php zfphinx
 ```
