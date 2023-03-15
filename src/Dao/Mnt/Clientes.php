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
`clientdatecrt` datetime DEFAULT NULL,
 */
/**
 * Undocumented class
 */
class Clientes extends Table{
    
    public static function insert(string $clientname, string $clientgender="MAS", string $clientphone1, string $clientphone2, string $clientemail, string $clientIdnumber, string $clientbio, string $clientstatus = "ACT"): int
    {
        $sqlstr = "INSERT INTO clientes (clientname, clientgender, clientphone1, clientphone2, clientemail, clientIdnumber, clientbio, clientstatus) values(:clientname, :clientgender, :clientphone1, :clientphone2, :clientemail, :clientIdnumber,  :clientbio, :clientstatus);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array("clientname" =>$clientname, "clientgender"=> $clientgender, "clientphone1"=> $clientphone1, "clientphone2"=>$clientphone2, "clientemail"=>$clientemail, "clientIdnumber"=>$clientIdnumber, "clientIdnumber"=>$clientIdnumber, "clientbio"=>$clientbio, "clientstatus"=>$clientstatus)
        );
        return $rowsInserted;
    }
    public static function update(
        string $clientname, string $clientgender, string $clientphone1, string $clientphone2, string $clientemail, string $clientIdnumber, string  $clientbio, string $clientstatus,
        int $clientid
    ){
        $sqlstr = "UPDATE clientes set clientname = :clientname, clientgender = :clientgender, clientphone1 = :clientphone1, clientphone2 = :clientphone2, clientemail = :clientemail, clientIdnumber = :clientIdnumber, clientbio = :clientbio, clientstatus = :clientstatus where clientid = :clientid;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "clientname" =>$clientname, "clientgender"=> $clientgender, "clientphone1"=> $clientphone1, "clientphone2"=>$clientphone2, "clientemail"=>$clientemail, "clientIdnumber"=>$clientIdnumber, "clientbio"=>$clientbio, "clientstatus"=>$clientstatus,
                "clientid" => $clientid
            )
        );
        return $rowsUpdated;
    }
    public static function delete(int $clientid){
        $sqlstr = "DELETE from clientes where clientid=:clientid;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "clientid" => $clientid
            )
        );
        return $rowsDeleted;
    }
    public static function findAll(){
        $sqlstr = "SELECT * from clientes;";
        return self::obtenerRegistros($sqlstr, array());
    }
    public static function findByFilter(){

    }
    public static function findById(int $clientid){
        $sqlstr = "SELECT * from categorias where clientid = :clientid;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "clientid"=> $clientid
            )
        );
        return $row;

        
    }
}
