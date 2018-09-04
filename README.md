# ListMaker

# Installation

### Require the package with composer
```
composer require leandro-grg/list-maker
```

### Publish the vendor assets
```bash
php artisan vendor:publish --provider='LeandroGRG\ListMaker\Providers\ListMakerServiceProvider'
```

### Add the provider to your application providers
```php
return [
    //...
    'providers' => [
        //...
        LeandroGRG\ListMaker\Providers\ListMakerServiceProvider::class
    ]
    //...
];
```

### Run the package migrations
```bash
php artisan migrate
```

### (optional) Alias
You can alias the class by adding the next code snippet to your `config/app.php`
```php
return [
    //...
    'aliases' => [
        //...
        'ListMaker' => LeandroGRG\ListMaker\ListGen
        //...
    ]
    //...
];
```

# Usage

To use a list generator, you only need to write this in your view:
```blade
{{ ListMaker::make('list-name') }}
```
Also, you can use the package's custom blade directive:
```blade
@list('list-name')
```
If you won't to use it on a `.blade.php` file, you can use plain php
```
<?php LeandroGRG\ListMaker\ListGen::make('list-name') ?>
```

### Creating lists
In order to create lists, just execute the command `php artisan list:create-list`,
and follow the steps in the interactive cli tool.
This will create an entry in the `lists` table, and the required folders:
`app/Helpers/ListTemplates` directory.

### Creating items
Run the command `php artisan list:create-list-item`. The command will prompt you for
the the main list to add the new item. Once you select the list, it will prompt you
for all the properties required for creating the item:
* **Type** `string` `required`: The item type (`item` or `divider`)
* **Route** `string` `nullable`: The item route.
* **Icon** `string` `nullable`: The item icon
* **Display** `string` `required`: The item display text
* **Order** `integer` `required`: The order of the item

# Templates
All the templates are located in the `app/Helpers/ListTemplates` directory.
For each list, a directory is created in `app/Helpers/ListTemplates/{StudlyCaseListName}`.

### Lists
Inside the `app/Helpers/ListTemplates/{StudlyCaseListName}` directory, you will
find two relevant files for the lists:
* **Parser**
    It's a generated class called `{StudlyCaseListName}Parser.php` with only one method,
    the `parse` method. It receives the `$list (Illuminate\Database\Eloquent\Model)`
    parameter, useful for replacing the strings in the template.
    The `parse` method returns an array to be used in the `strtr` php function.

* **Template**
    Inside the folder, you can find a file called `ListTemplate.html`. That's the
    list template, you can modify it as you like.

### List items
Basically, it works like the list parser, with a little difference:
* **Parser**
    In this case, the parser will have a method for each type of item, following the
    pattern `parse{Type}Type`. For example, this will be the method for a divider
    type item:
```php
<?php

static function parseDividerType ($item)
{
    return [];
}
```

# Adding custom item types
We're working on this. At the moment, you can use the `item` and `divider` item types.
