<?php

namespace DivineOmega\ThisIsHowIRole;

use DivineOmega\ThisIsHowIRole\RolesManager;

trait RolesTrait
{
  public $roles = null;

  public function __construct()
  {
    $this->roles = new RolesManager($this);
    parent::__construct();
  }

}
