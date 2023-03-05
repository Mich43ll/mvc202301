<?php
namespace Dao\Clases;

use Dao\Table;

class Demo extends Table{
    public static function getResponse(){
        return self::obtenerRegistros('Select 1 as Response;',array());
    }
}

?>