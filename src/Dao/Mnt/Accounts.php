<?php

namespace Dao\Mnt;

use Dao\Table;

use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

/*
account_id INT AUTO_INCREMENT PRIMARY KEY,
account_name VARCHAR(255) NOT NULL,
account_type ENUM('ASSET', 'LIABILITY', 'EQUITY', 'INCOME', 'EXPENSE') NOT NULL,
balance DECIMAL(10,2) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP
*/

class Accounts extends table
{

    public static function getAll()
    {
        return self::obtenerRegistros("SELECT * FROM accounts", array());
    }

    public static function getById(int $account_id)
    {
        return self::obtenerUnRegistro("SELECT * FROM accounts WHERE account_id = :account_id", array("account_id" => $account_id));
    }

    public static function insert(
        string $account_name,
        string $account_type,
        float $balance,
        string $created_at
    ) {
        $ins_sql = "INSERT INTO `accounts`
        (`account_name`,
        `account_type`,
        `balance`,
        `created_at`)
        VALUES
        (:account_name,
        :account_type,
        :balance,
        :created_at);";

        return self::executeNonQuery($ins_sql, array(
            "account_name" => $account_name,
            "account_type" => $account_type,
            "balance" => $balance,
            "created_at" => $created_at
        ));
    }

    public static function update(
        string $account_name,
        string $account_type,
        float $balance,
        string $created_at,
        int $account_id
    )
    {
        $upd_sql = "UPDATE `accounts`
        SET
        `account_name` = :account_name,
        `account_type` = :account_type,
        `balance` = :balance,
        `created_at` = :created_at
        WHERE `account_id` = :account_id;
        ";

        return self::executeNonQuery($upd_sql, array(
            "account_name" => $account_name,
            "account_type" => $account_type,
            "balance" => $balance,
            "created_at" => $created_at,
            "account_id" => $account_id
        ));
    }

    public static function delete(string $account_id)
    {
        $del_sql = "DELETE FROM `accounts`
        WHERE account_id = :account_id;";
        return self::executeNonQuery($del_sql, array("account_id" => $account_id));
    }
}
