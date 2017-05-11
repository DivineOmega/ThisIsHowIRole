<?php

/* Environmental variables (typically you'd use a `.env` file or similar) */

putenv('TIHIR_DB_TYPE=mysql');
putenv('TIHIR_DB_NAME=tihir_test');
putenv('TIHIR_DB_HOST=192.168.1.44');
putenv('TIHIR_DB_USER=root');
putenv('TIHIR_DB_PASSWORD=P@SSw0Rd!');

/* Require autoload */

require_once __DIR__.'/../vendor/autoload.php';

/* Test User class */

use DivineOmega\ThisIsHowIRole\RolesTrait as Roles;

class User
{
  use Roles;

  public $id = 123;

}

/* Test role changes */

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
