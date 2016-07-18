<?php

namespace DivineOmega\ThisIsHowIRole;

use DivineOmega\ThisIsHowIRole\RolesManager;

trait RolesTrait
{
  public $roles = null;

  public function __construct()
  {
    $this->roles = new RolesManager($this);

    if (get_parent_class($this)!==false) {

      $parentConstructor = parent::__construct();

      if (is_callable($parentConstructor)) {
        $parentConstructor();
      }

    }
  }

}
