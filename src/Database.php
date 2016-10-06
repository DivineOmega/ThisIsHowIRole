<?php

namespace DivineOmega\ThisIsHowIRole;

abstract class Database
{
  private static $connection = null;
  private static $table = 'tihir_roles';

  private static function getConnection()
  {
    if (self::$connection!==null) {
      return self::$connection;
    }

    if (getenv('TIHIR_USE_LARAVEL_DB')==='true') {

      self::$connection = \Illuminate\Support\Facades\DB::connection()->getPdo();

    } else {

      $type = getenv('TIHIR_DB_TYPE');
      $name = getenv('TIHIR_DB_NAME');
      $host = getenv('TIHIR_DB_HOST');
      $user = getenv('TIHIR_DB_USER');
      $password = getenv('TIHIR_DB_PASSWORD');

      $dsn = $type.':dbname='.$name.';host='.$host;

      self::$connection = new \PDO($dsn, $user, $password);
      
    }      
    
    return self::$connection;
  }

  private static function getRoles($className, $foreignId)
  {
    $connection = self::getConnection();

    $sql = 'select * from '.self::$table.' where class_name = ? and foreign_id = ?';

    $stmt = $connection->prepare($sql);
    $stmt->execute([$className, $foreignId]);
    $roleObj = $stmt->fetchObject();

    if (!is_object($roleObj)) {

      $sql = 'insert into '.self::$table.' set roles = ?, class_name = ?, foreign_id = ?';

      $stmt = $connection->prepare($sql);
      $stmt->execute(['', $className, $foreignId]);

      return '';
    }

    return $roleObj->roles;
  }

  private static function setRoles($className, $foreignId, $roles)
  {
    $connection = self::getConnection();

    $sql = 'update '.self::$table.' set roles = ? where class_name = ? and foreign_id = ?';

    $stmt = $connection->prepare($sql);
    $stmt->execute([$roles, $className, $foreignId]);
  }

  public static function add($className, $foreignId, $role)
  {
    $roles = self::getRoles($className, $foreignId);

    $rolesArray = explode(' ', $roles);
    $key = array_search($role, $rolesArray);
    if ($key!==false) {
      return;
    }
    $rolesArray[] = $role;
    $roles = implode(' ', $rolesArray);

    self::setRoles($className, $foreignId, $roles);

  }

  public static function remove($className, $foreignId, $role)
  {
    $roles = self::getRoles($className, $foreignId);

    $rolesArray = explode(' ', $roles);
    $key = array_search($role, $rolesArray);
    if ($key===false) {
      return;
    }
    unset($rolesArray[$key]);
    $roles = implode(' ', $rolesArray);

    self::setRoles($className, $foreignId, $roles);

  }

  public static function has($className, $foreignId, $role)
  {
    $roles = self::getRoles($className, $foreignId);

    $rolesArray = explode(' ', $roles);
    $key = array_search($role, $rolesArray);

    if ($key===false) {
      return false;
    }

    return true;

  }

  public static function all($className, $foreignId)
  {
    $roles = self::getRoles($className, $foreignId);

    $rolesArray = explode(' ', $roles);

    return $rolesArray;

  }

}
