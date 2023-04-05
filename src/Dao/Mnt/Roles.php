<?php

namespace Dao\Mnt;

use Dao\Table;

/*
CREATE TABLE `roles` (
  `rol_id` varchar(15) NOT NULL,
  `rol_dsc` varchar(45) NOT NULL,
  `rol_est` char(5) NOT NULL,
  PRIMARY KEY (`rol_id`)
)
*/

class Roles extends Table
{
    public static function getAll()
    {
        return self::obtenerRegistros("SELECT * FROM roles", array());
    }

    public static function getById(int $rol_id)
    {
        return self::obtenerUnRegistro("SELECT * FROM roles WHERE rol_id = :rol_id", array("rol_id" => $rol_id));
    }

    public static function insert(
        int $rol_id,
        string $rol_dsc,
        string $rol_est,
    ) {
        $ins_sql = "INSERT INTO `roles`
        (`rol_id`,
        `rol_dsc`,
        `rol_est`)
        VALUES
        (:rol_id,
        :rol_dsc,
        :rol_est);";

        return self::executeNonQuery($ins_sql, array(
            "rol_id" => $rol_id,
            "rol_dsc" => $rol_dsc,
            "rol_est" => $rol_est
        ));
    }

    public static function update(
        int $rol_id,
        string $rol_dsc,
        string $rol_est,
    ) {
        $upd_sql = "UPDATE `roles`
        SET
        `rol_id` = :rol_id,
        `rol_dsc` = :rol_dsc,
        `rol_est` = :rol_est
        WHERE `rol_id` = :rol_id;
        ";

        return self::executeNonQuery($upd_sql, array(
            "rol_id" => $rol_id,
            "rol_dsc" => $rol_dsc,
            "rol_est" => $rol_est
        ));
    }

    public static function delete(int $rol_id)
    {
        $del_sql="DELETE FROM roles WHERE rol_id = :rol_id;";
        return self::executeNonQuery($del_sql, array("rol_id" => $rol_id));
    }
}
