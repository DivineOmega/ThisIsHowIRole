<?php

namespace DivineOmega\ThisIsHowIRole;

use DivineOmega\ThisIsHowIRole\DatabaseDrivers\PDODatabaseDriver;
use DivineOmega\ThisIsHowIRole\DatabaseDrivers\EloquentDatabaseDriver;

class RolesManager
{
  private $object = null;
  private $database = null;

  public function __construct($object)
  {
    if (!$object || !is_object($object)) {
      throw new \Exception('TIHIR: Invalid object passed to RolesManager.');
    }

    if (!isset($object->id) || !is_numeric($object->id)) {
      throw new \Exception('TIHIR: Object passed to RolesManager does not contain an accessible numeric id field.');
    }

    $this->object = $object;

    if (class_exists('Illuminate\Database\Eloquent\Model')) {
      $this->database = new EloquentDatabaseDriver();
    } else {
      $this->database = new PDODatabaseDriver();
    }

    $this->database->setupCache();
  }

  public function add($role)
  {
    $this->database->add(get_class($this->object), $this->object->id, $role);
  }

  public function remove($role)
  {
    $this->database->remove(get_class($this->object), $this->object->id, $role);
  }

  public function has($role)
  {
    return $this->database->has(get_class($this->object), $this->object->id, $role);
  }

  public function all()
  {
    return $this->database->all(get_class($this->object), $this->object->id);
  }
}
