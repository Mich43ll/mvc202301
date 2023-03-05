<?php

namespace Dao\Mnt;

use Dao\Table;


/*
`catid` BIGINT(8) NOT NULL AUTO_INCREMENT,
`catnom` VARCHAR(45) NULL,
`catest` CHAR(3) NULL DEFAULT 'ACT',
*/

class Categorias extends Table
{
    /**
     * Crea un nuevo registro de categoria 
     *
     * @param [type] $catnom
     * @param string $catest
     * @return void
     */
    public static function insert($catnom, $catest = "ACT"): int
    {
        $sqlstr = "INSERT INTO categorias (catnom, catest) values (?, ?);";
        $rowsInserted = self::executeNonQuery($sqlstr, array("catnom" => $catnom, "catest" => $catest));

        return $rowsInserted;
    }
    public static function update(string $catnom, string $catest, int $catid)
    {
        $sqlstr = "UPDATE categorias set catnom= :catnom, catest = :catest where catid = :catid;";
        $rowsUpdated = self::executeNonQuery($sqlstr, array("catnom" => $catnom, "catest" => $catest, "catid" => $catid));
        return $rowsUpdated;
    }
    public static function delete(int $catid)
    {
        $sqlstr = "DELETE FROM categorias where catid = :catid;";
        $rowsDeleted = self::executeNonQuery($sqlstr, array("catid" => $catid));
    }
    public static function findAll()
    {
        $sqlstr = "SELECT * FROM categorias;";
        return self::obtenerRegistros($sqlstr, array());
    }
    public static function findByFilter()
    {
    }
    public static function findById(int $catid)
    {
        $sqlstr = "SELECT * FROM categorias where catid = :catid;";
        return self::obtenerRegistros($sqlstr, array("catid" => $catid));
        $row = self::obtenerUnRegistro($sqlstr, array("catid" => $catid));
        return $row;
    }
}

?>