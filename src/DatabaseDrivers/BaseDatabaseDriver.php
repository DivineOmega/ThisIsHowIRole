<?php

namespace DivineOmega\ThisIsHowIRole\DatabaseDrivers;

use DivineOmega\ThisIsHowIRole\Interfaces\DatabaseDriverInterface;

abstract class BaseDatabaseDriver implements DatabaseDriverInterface
{
  protected $testMode = false;

  public function setTestMode($testMode) {
    $this->testMode = $testMode;
  }

  public function add($className, $foreignId, $role)
  {
    $roles = $this->getRoles($className, $foreignId);

    $rolesArray = explode(' ', $roles);
    $key = array_search($role, $rolesArray);
    if ($key!==false) {
      return;
    }
    $rolesArray[] = $role;
    $roles = implode(' ', $rolesArray);

    $this->setRoles($className, $foreignId, $roles);

  }

  public function remove($className, $foreignId, $role)
  {
    if ($this->testMode) {
      return;
    }

    $roles = $this->getRoles($className, $foreignId);

    $rolesArray = explode(' ', $roles);
    $key = array_search($role, $rolesArray);
    if ($key===false) {
      return;
    }
    unset($rolesArray[$key]);
    $roles = implode(' ', $rolesArray);

    $this->setRoles($className, $foreignId, $roles);

  }

  public function has($className, $foreignId, $role)
  {
    if ($this->testMode) {
      return true;
    }

    $roles = $this->getRoles($className, $foreignId);

    $rolesArray = explode(' ', $roles);
    $key = array_search($role, $rolesArray);

    if ($key===false) {
      return false;
    }

    return true;

  }

  public function all($className, $foreignId)
  {
    if ($this->testMode) {
      return  '';
    }

    $roles = $this->getRoles($className, $foreignId);

    $rolesArray = explode(' ', $roles);

    return $rolesArray;

  }

}
