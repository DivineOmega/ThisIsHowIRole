# This Is How I Role (TIHIR)

'This Is How I Role' is a PHP role management system that can be applied to any
class.

## Installation

You can use `composer` to install this package. 
Just run `composer require divineomega/thisishowirole`.

## Setup

### Table creation

First, create a new table in your application's database to store the TIHIR
roles. You can use the following SQL snippet to create the table.

```sql
CREATE TABLE IF NOT EXISTS `tihir_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(1000) NOT NULL,
  `foreign_id` bigint(20) NOT NULL,
  `roles` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
```

If you're using Laravel, you can use the following database migration to
create the TIHIR roles table.

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThisIsHowIRoleRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tihir_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_name');
            $table->bigInteger('foreign_id');
            $table->text('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tihir_roles');
    }
}
```

### Database connection configuration

If you're using Laravel, TIHIR will automatically use the database you've
configured for your application, so you don't need to do anything here. 
We'll also use Eloquent to communicate with your database.

Otherwise, you need to set some environmental variables to point TIHIR towards your
database. Something similar to the following will do the trick. If you're using
a framework that supports it, you can put this in your `.env` file. If not, 
you can use PHP's built in `putenv` function.

```
TIHIR_DB_TYPE=mysql
TIHIR_DB_NAME=tihir_test
TIHIR_DB_HOST=192.168.1.44
TIHIR_DB_USER=tihir_test
TIHIR_DB_PASSWORD=PAMBSHcHssQqpw4A
```

## Usage

This Is How I Role works by enhancing existing classes. This will work on any
PHP class, be it a manually created class or a Laravel Eloquent model. The only
requirement is that the class must have an accessible, numeric `id` property.

All you need to do is add two extra `use` lines to your class. This is shown in
the example `User` class shown below.

```php
require 'vendor/autoload.php';

use DivineOmega\ThisIsHowIRole\RolesTrait as Roles; // <-- Line 1

class User
{
  use Roles; // <-- Line 2

  public $id = 123;

}
```

This `User` class now has the TIHIR roles system available to it. You can now
use various methods to add, remove or check for roles against this class. The
snippet below shows how roles can be manipulated.

```php
$user = new User;

$user->roles->add('can_eat_cake');
$user->roles->add('can_eat_cookies');
$user->roles->remove('can_eat_cookies');

echo 'This user can ';

if ($user->roles->has('can_eat_cake')) {
  echo 'eat cakes... ';
}

if ($user->roles->has('can_eat_cookies')) {
  echo 'eat cookies... ';
}

echo "\n";
```
