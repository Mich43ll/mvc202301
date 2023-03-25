<?php

namespace Dao\Mnt;

use Dao\Table;

/*
`fncod` varchar(255) NOT NULL,
  `fndsc` varchar(45) DEFAULT NULL,
  `fnest` char(3) DEFAULT NULL,
  `fntyp` char(3) DEFAULT NULL,
*/

class Funciones extends table
{
    public static function getAll()
    {
        return self::obtenerRegistros("SELECT * FROM funciones", array());
    }

    public static function getById(int $fncod)
    {
        return self::obtenerUnRegistro("SELECT * FROM funciones WHERE fncod = :fncod", array("fncod" => $fncod));
    }

    public static function insert(
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $ins_sql = "INSERT INTO `funciones`
        (`fndsc`,
        `fnest`,
        `fntyp`)
        VALUES
        (:fndsc,
        :fnest,
        :fntyp);
        ";

        return self::executeNonQuery($ins_sql, array(
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp

        ));
    }

    public static function delete(string $fncod)
    {
        $del_sql = "DELETE FROM `funciones`
        WHERE fncod = :fncod;";
        return self::executeNonQuery($del_sql, array("fncod" => $fncod));
    }

    public static function update(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $upd_sql = "UPDATE `funciones`
        SET
        `fndsc` = :fndsc,
        `fnest` = :fnest,
        `fncod` = :fncod,
        `fntyp` = :fntyp
        WHERE `fncod` = :fncod;";

        return self::executeNonQuery($upd_sql, array(
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp,
            "fncod" => $fncod
        ));
    }
}
