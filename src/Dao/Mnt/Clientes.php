<?php

namespace Dao\Mnt;

use Dao\Table;

/*
`clientid` bigint(15) NOT NULL AUTO_INCREMENT,
  `clientname` varchar(128) DEFAULT NULL,
  `clientgender` char(3) DEFAULT NULL,
  `clientphone1` varchar(255) DEFAULT NULL,
  `clientphone2` varchar(255) DEFAULT NULL,
  `clientemail` varchar(255) DEFAULT NULL,
  `clientIdnumber` varchar(45) DEFAULT NULL,
  `clientbio` varchar(5000) DEFAULT NULL,
  `clientstatus` char(3) DEFAULT NULL,
*/

class Clientes extends table
{
    public static function getAll()
    {
        $sqlstr = "SELECT * FROM clientes";
        return self::obtenerRegistros($sqlstr, array());
    }
    public static function getById(int $clientid)
    {
        return self::obtenerUnRegistro("SELECT * FROM clientes WHERE clientid = $clientid", array("clientid" => $clientid));
    }

    public static function insert(
        string $clientname,
        string $clientgender,
        string $clientphone1,
        string $clientphone2,
        string $clientemail,
        string $clientIdnumber,
        string $clientbio,
        string $clientstatus
    ) {
        $ins_sql = "INSERT INTO clientes
        (clientname,
        clientgender,
        clientphone1,
        clientphone2,
        clientemail,
        clientIdnumber,
        clientbio,
        clientstatus)
        VALUES
        (:clientname,
        :clientgender,
        :clientphone1,
        :clientphone2,
        :clientemail,
        :clientIdnumber,
        :clientbio,
        :clientstatus);
        ";
        $rowsInserted = self::executeNonQuery($ins_sql, array(
            "clientname" =>$clientname,
        "clientgender"=> $clientgender,
        "clientphone1" => $clientphone1,
        "clientphone2" => $clientphone2,
        "clientemail" => $clientemail,
        "clientIdnumber" => $clientIdnumber,
        "clientbio" => $clientbio,
        "clientstatus" => $clientstatus
        ));
        return $rowsInserted;
    }

    public static function update(
        int $clientid,
        string $clientname,
        string $clientgender,
        string $clientphone1,
        string $clientphone2,
        string $clientemail,
        string $clientIdnumber,
        string $clientbio,
        string $clientstatus
    ) {
        $upd_sql = "UPDATE `clientes`
        SET
        `clientname` = :clientname,
        `clientgender` = :clientgender,
        `clientphone1` = :clientphone1,
        `clientphone2` = :clientphone2,
        `clientemail` = :clientemail,
        `clientIdnumber` = :clientIdnumber,
        `clientbio` = :clientbio,
        `clientstatus` = :clientstatus
        WHERE `clientid` = :clientid ;";
        $rowsUpdated = self::executeNonQuery($upd_sql, array(
            "clientname" =>$clientname,
        "clientgender"=> $clientgender,
        "clientphone1" => $clientphone1,
        "clientphone2" => $clientphone2,
        "clientemail" => $clientemail,
        "clientIdnumber" => $clientIdnumber,
        "clientbio" => $clientbio,
        "clientstatus" => $clientstatus,
        "clientid" => $clientid
        ));
        return $rowsUpdated;
    }

    public static function delete(string $clientid)
    {
        $del_sql = "DELETE FROM `clientes`
        WHERE clientid = :clientid;";
        $rowsDeleted = self::executeNonQuery($del_sql, array("clientid" => $clientid));
        return $rowsDeleted;
    }
}

?>