<?php

namespace DivineOmega\ThisIsHowIRole\DatabaseDrivers;

use DivineOmega\ThisIsHowIRole\Interfaces\DatabaseDriverInterface;
use DivineOmega\ThisIsHowIRole\DatabaseDrivers\BaseDatabaseDriver;
use DivineOmega\ThisIsHowIRole\DatabaseDrivers\Eloquent\Role;

class EloquentDatabaseDriver extends BaseDatabaseDriver implements DatabaseDriverInterface
{

  protected function getRoles($className, $foreignId)
  {
    if ($this->testMode) {
      return '';
    }

    $role = Role::where('class_name', $className)->where('foreign_id', $foreignId)->limit(1)->first();

    if (!$role) {
      $role = new Role;
      $role->roles = '';
      $role->class_name = $className;
      $role->foreign_id = $foreignId;
    }

    return $role->roles;
  }

  protected function setRoles($className, $foreignId, $roles)
  {
    if ($this->testMode) {
      return;
    }

    $role = Role::where('class_name', $className)->where('foreign_id', $foreignId)->limit(1)->first();

    $role->roles = $roles;
    $role->save();
  }

}
