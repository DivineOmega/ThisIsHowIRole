<?php

namespace DivineOmega\ThisIsHowIRole\Interfaces;

interface DatabaseDriverInterface
{
  public function add($className, $foreignId, $role);
  public function remove($className, $foreignId, $role);
  public function all($className, $foreignId);
  
}
