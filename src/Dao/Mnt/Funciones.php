<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Funciones extends Table{

        public static function insert(
            string $fncod, 
            string $fndsc,
            string $fnest="ACT",
            string $fntyp="ABC"
            ): int
        { 
            $sqlstr = "INSERT INTO funciones (
                fncod, 
                fndsc, 
                fnest,
                fntyp
                ) values(
                    :fncod, 
                    :fndsc, 
                    :fnest,
                    :fntyp
                    );";
            $rowsinserted = self::executeNonQuery(
                $sqlstr,
                array(
                    "fncod"=>$fncod, 
                    "fndsc"=>$fndsc, 
                    "fnest"=>$fnest,
                    "fntyp"=>$fntyp
                    )
            );
            return $rowsinserted;
        }
        public static function update(
            string $fndsc,
            string $fnest,
            string $fntyp,
            string $fncod
        ){
            $sqlstr="UPDATE funciones set
             fndsc = :fndsc, 
             fnest = :fnest,
             fntyp = :fntyp 
             where fncod = :fncod;";
            $rowsUpdated = self::excuteNonQuery(
                $sqlstr,
                array(
                    "fndsc" => $fndsc,
                    "fnest" => $fnest,
                    "fntyp" => $fntyp,
                    "fncod" => $fncod
                )
            );
            return $rowsUpdated;
        }
        public static function delete(int $fncod){
            $sqlstr = "DELETE from funciones where fncod = :fncod;";
            $rowsDeleted = self::executeNonQuery(
                $sqlstr,
                array(
                    "fncod" => $fncod
                )
                );
                return $rowsDeleted;
        }
        public static function findAll(){
            $sqlstr = "SELECT * FROM funciones;";
            return self::obtenerRegistros($sqlstr, array());     
        }
        public static function findByFilter(){
            
        }
        public static function findById(){
            $sqlstr = "SELECT * from funciones where fncod = :fncod;";
            $row = self::obtenerUnRegistro(
                $sqlstr,
                array(
                    "fncod" => $fncod
                )
                );
            return $row;     
        }
    }
?>