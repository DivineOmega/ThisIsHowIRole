<?php

namespace DivineOmega\ThisIsHowIRole;

use DivineOmega\ThisIsHowIRole\RolesManager;

trait RolesTrait
{
  private $rolesManager = null;

  public function __get($key)
  {
    if ($key!='roles') {
      return parent::__get($key);
    }

    if ($this->rolesManager==null) {
      $this->rolesManager = new RolesManager($this);
    }

    return $this->rolesManager;
   }

}
