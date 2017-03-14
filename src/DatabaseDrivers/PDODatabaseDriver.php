<?php

namespace DivineOmega\ThisIsHowIRole\DatabaseDrivers;

use DivineOmega\ThisIsHowIRole\Interfaces\DatabaseDriverInterface;
use DivineOmega\ThisIsHowIRole\DatabaseDrivers\BaseDatabaseDriver;
use DivineOmega\ThisIsHowIRole\Utils;

class PDODatabaseDriver extends BaseDatabaseDriver implements DatabaseDriverInterface
{
  protected $connection = null;
  protected $table = 'tihir_roles';

  private function getConnection()
  {
    if ($this->connection!==null) {
      return $this->connection;
    }

    $type = getenv('TIHIR_DB_TYPE');
    $name = getenv('TIHIR_DB_NAME');
    $host = getenv('TIHIR_DB_HOST');
    $user = getenv('TIHIR_DB_USER');
    $password = getenv('TIHIR_DB_PASSWORD');

    $dsn = $type.':dbname='.$name.';host='.$host;

    $this->connection = new \PDO($dsn, $user, $password);    
    
    return $this->connection;
  }

  private function cacheKey($className, $foreignId)
  {
    return 'TIHIR_PDO_'.$className.'_'.$foreignId;
  }

  protected function getRoles($className, $foreignId)
  {
    if (Utils::testModeActive()) {
      return '';
    }

    $cacheKey = $this->cacheKey($className, $foreignId);

    if (!($roles = $this->cache->get($cacheKey)))
    {

      $connection = $this->getConnection();

      $sql = 'select * from '.$this->table.' where class_name = ? and foreign_id = ?';

      $stmt = $connection->prepare($sql);
      $stmt->execute([$className, $foreignId]);
      $roleObj = $stmt->fetchObject();

      if (!is_object($roleObj)) {

        $sql = 'insert into '.$this->table.' set roles = ?, class_name = ?, foreign_id = ?';

        $stmt = $connection->prepare($sql);
        $stmt->execute(['', $className, $foreignId]);

        return '';
      }

      $roles = $roleObj->roles;

      $this->cache->set($cacheKey, $roles);

    }

    return $roles;
  }

  protected function setRoles($className, $foreignId, $roles)
  {
    if (Utils::testModeActive()) {
      return;
    }

    $cacheKey = $this->cacheKey($className, $foreignId);

    $this->cache->delete($cacheKey);

    $connection = $this->getConnection();

    $sql = 'update '.$this->table.' set roles = ? where class_name = ? and foreign_id = ?';

    $stmt = $connection->prepare($sql);
    $stmt->execute([$roles, $className, $foreignId]);
  }

}
