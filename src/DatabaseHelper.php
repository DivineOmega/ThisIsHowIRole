<? 
namespace DivineOmega\ThisIsHowIRole;

use DivineOmega\ThisIsHowIRole\DatabaseDrivers\PDODatabaseDriver;
use DivineOmega\ThisIsHowIRole\DatabaseDrivers\EloquentDatabaseDriver;

abstract class DatabaseHelper
{
public static function getDatabaseDriver()
{
    if (class_exists('Illuminate\Database\Eloquent\Model')) {
        return new EloquentDatabaseDriver();
      } else {
        return  new PDODatabaseDriver();
      }
}
}