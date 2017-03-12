<?php

namespace DivineOmega\ThisIsHowIRole\Interfaces;

interface DatabaseDriverInterface
{
  public function setTestMode($testMode);
  public function add($className, $foreignId, $role);
  public function remove($className, $foreignId, $role);
  public function all($className, $foreignId);
  
}
