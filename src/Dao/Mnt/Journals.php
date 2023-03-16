<?php

namespace Dao\Mnt;

use Dao\Table;

/*
CREATE TABLE journals (
    journal_id INT AUTO_INCREMENT PRIMARY KEY,
    journal_date DATE NOT NULL,
    journal_type ENUM('DEBIT', 'CREDIT') NOT NULL,
    journal_description VARCHAR(255) NOT NULL,
    journal_amount DECIMAL(10,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
*/

class Journals extends table
{
    public static function getAll()
    {
        return self::obtenerRegistros("SELECT * FROM journals", array());
    }
    public static function getById(int $journal_id)
    {
        return self::obtenerUnRegistro("SELECT * FROM journals WHERE journal_id = $journal_id", array("journal_id" => $journal_id));
    }

    public static function insert(
        string $journal_description,
        string $journal_type,
        string $journal_date,
        float $journal_amount
    ) {
        $ins_sql = "INSERT INTO `journals`
(`journal_date`,
`journal_type`,
`journal_description`,
`journal_amount`,
`created_at`)
VALUES
(:journal_date,
:journal_type,
:journal_description,
:journal_amount,
now());";

        return self::executeNonQuery($ins_sql, array(
            "journal_date" => $journal_date,
            "journal_type" => $journal_type,
            "journal_description" => $journal_description,
            "journal_amount" => $journal_amount,
        ));
    }

    public static function update(
        string $journal_description,
        string $journal_type,
        string $journal_date,
        float $journal_amount,
        int $journal_id
    ) {
        $upd_sql = "UPDATE `journals`
        SET
        `journal_date` = :journal_date,
        `journal_type` = :journal_type ,
        `journal_description` = :Journal_description ,
        `journal_amount` = :journal_amount: 
        WHERE `journal_id` = :journal_id;";

        return self::executeNonQuery($upd_sql, array(
            "journal_date" => $journal_date,
            "journal_type" => $journal_type,
            "journal_description" => $journal_description,
            "journal_amount" => $journal_amount,
            "journal_id" => $journal_id
        ));
    }

    public static function delete(string $journal_id)
    {
        $del_sql = "DELETE FROM`journals`
        WHERE journal_id = :journal_id;";
        return self::executeNonQuery($del_sql, array("journal_id" => $journal_id));
    }
}
