<?php

namespace DivineOmega\ThisIsHowIRole;

use DivineOmega\ThisIsHowIRole\Database;

class RolesManager
{
  private $object = null;

  public function __construct($object)
  {
    if (!$object || !is_object($object)) {
      throw new \Exception('TIHIR: Invalid object passed to RolesManager.');
    }

    if (!isset($object->id) || !is_numeric($object->id)) {
      throw new \Exception('TIHIR: Object passed to RolesManager does not contain an accessible numeric id field.');
    }

    $this->object = $object;
  }

  public function add($role)
  {
    Database::add(get_class($this->object), $this->object->id, $role);
  }

  public function remove($role)
  {
    Database::remove(get_class($this->object), $this->object->id, $role);
  }

  public function has($role)
  {
    return Database::has(get_class($this->object), $this->object->id, $role);
  }

  public function all()
  {
    return Database::all(get_class($this->object), $this->object->id);
  }
}
