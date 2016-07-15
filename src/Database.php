<?php

namespace DivineOmega\ThisIsHowIRole;

abstract class Database
{
  private static $connection = null;
  private static $table = 'tihir_roles';

  private static function getConnection()
  {
    $name = getenv('TIHIR_MYSQL_DB_NAME');
    $host = getenv('TIHIR_MYSQL_DB_HOST');
    $user = getenv('TIHIR_MYSQL_DB_USER');
    $password = getenv('TIHIR_MYSQL_DB_PASSWORD');

    $dsn = 'mysql:dbname='.$name.';host='.$host;

    if ($connection==null) {
      $this->connection = new PDO($dsn, $user, $password);
    }

    return $connection;
  }

  public static function add($className, $foreignId, $role)
  {
    $connection = self::getConnection();

    $sql = 'select * from '.$this->table.' where class_name = ? and foreign_id = ?';

    $roleObj = \PDO::prepare($sql)->execute($className, $foreignId)->fetchObject();

    $roles = $roleObj->roles;

    if (stripos($roles, $role)===false) {
      return;
    }

    $rolesArray = explode(' ', $roles);
    $rolesArray[] = $role;
    $roles = implode(' ', $rolesArray);

    $sql = 'update '.$this->table.' set roles = ? where class_name = ? and foreign_id = ?';

    \PDO::prepare($sql)->execute($roles, $className, $foreignId);

  }

  public static function remove($className, $foreignId, $role)
  {
    $connection = self::getConnection();

    $sql = 'select * from '.$this->table.' where class_name = ? and foreign_id = ?';

    $roleObj = \PDO::prepare($sql)->execute($className, $foreignId)->fetchObject();

    $roles = $roleObj->roles;

    if (stripos($roles, $role)===false) {
      return;
    }

    $rolesArray = explode(' ', $roles);
    $key = array_search($role, $rolesArray);
    unset($rolesArray[$key]);
    $roles = implode(' ', $rolesArray);

    $sql = 'update '.$this->table.' set roles = ? where class_name = ? and foreign_id = ?';

    \PDO::prepare($sql)->execute($roles, $className, $foreignId);

  }

  public static function has($className, $foreignId, $role)
  {
    $connection = self::getConnection();

    $sql = 'select * from '.$this->table.' where class_name = ? and foreign_id = ?';

    $roleObj = \PDO::prepare($sql)->execute($className, $foreignId)->fetchObject();

    $roles = $roleObj->roles;

    if (stripos($roles, $role)===false) {
      return false;
    }

    return true;

  }

}
