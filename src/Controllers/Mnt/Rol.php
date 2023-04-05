<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;
/*
`rol_id` varchar(15) NOT NULL,
`rol_dsc` varchar(45) NOT NULL,
`rol_est` char(5) NOT NULL,
*/
class Rol extends PublicController{

      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private $redirectTo = "index.php?page=Mnt-Roles";


      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "rol_id" => "0",
        "rol_dsc" => "",
        "rol_est" => "ACT",
        "rol_est_ACT" => "selected",
        "rol_est_INA" => "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
        
    );

      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Rol",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Borrar %s (%s)"
    );

      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function run() :void
    {
            $this->page_loaded();
            if($this->isPostBack()){
                $this->validatePostData();
                if(!$this->viewData["has_errors"]){
                    $this->executeAction();
                }
            }
            $this->render();


    }

      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private function page_loaded()
    {
        if(isset($_GET['mode'])){
            if(isset($this->modes[$_GET['mode']])){
                $this->viewData["mode"] = $_GET['mode'];
            } else {
                throw new Exception("Mode Not available");
            }
        } else {
            throw new Exception("Mode not defined on Query Params");
        }
        if($this->viewData["mode"] !== "INS") {
            if(isset($_GET['rol_id'])){
                $this->viewData["rol_id"] = intval($_GET["rol_id"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }

        ///////////////////////////////////////////////////////INICIO DE LOS CAMPOS DE LA TABLA JOURNAL///////////////////////////////////////////////////////
        private function validatePostData(){
        if(isset($_POST["rol_dsc"])){
            if(\Utilities\Validators::IsEmpty($_POST["rol_dsc"])){
                $this->viewData["has_errors"] = true;
            }
        } else {
            throw new Exception("Rol description not present in form");
        }

        ///////////////////////////////////////////////////////
        if(isset($_POST["rol_est"])){
            if (!in_array( $_POST["rol_est"], array("ACT","INA"))){
                throw new Exception("rol_est incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("rol_est not present in form");
            }
        }

        ///////////////////////////////////////////////////////FINAL DE LOS CAMPOS DE LA TABLA JOURNAL///////////////////////////////////////////////////////

        ///////////////////////////////////////////////////////
        if(isset($_POST["mode"])){
            if(!key_exists($_POST["mode"], $this->modes)){
                throw new Exception("mode has a bad value");
            }
            if($this->viewData["mode"]!== $_POST["mode"]){
                throw new Exception("mode value is different from query");
            }
        }else {
            throw new Exception("mode not present in form");
        }

        ///////////////////////////////////////////////////////
        if(isset($_POST["rol_id"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["rol_id"])<=0)){
                throw new Exception("rol_id is not Valid");
            }
        }else {
            throw new Exception("rol_id not present in form");
        }
        ////////////////////////////////////
        $tmpPostData = array(
                            "rol_id" => $_POST["rol_id"],
                            "rol_dsc" => $_POST["rol_dsc"],
                            "rol_est" => $_POST["rol_est"]
                                    );


        ////////////////////////////////////

        \Utilities\ArrUtils::mergeFullArrayTo($tmpPostData, $this->viewData
        );
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["rol_est"] = $_POST["rol_est"];
        }
    }


      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Roles::insert(
                    $this->viewData["rol_id"],
                    $this->viewData["rol_dsc"],
                    $this->viewData["rol_est"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Rol Creado Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Roles::update(
                    $this->viewData["rol_id"],
                    $this->viewData["rol_dsc"],
                    $this->viewData["rol_est"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Rol Actualizado Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Roles::delete(
                    $this->viewData["rol_id"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Rol Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        $xssToken = md5("ROL" . rand(0,4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_rol"] = $xssToken;

        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpRoles = \Dao\Mnt\Roles::getById($this->viewData["rol_id"]);
            if(!$tmpRoles){
                throw new Exception("rol no existe en DB");
            }
            //$this->viewData["catnom"] = $tmpJournal["catnom"];
            //$this->viewData["catest"] = $tmpJournal["catest"];
            \Utilities\ArrUtils::mergeFullArrayTo($tmpRoles, $this->viewData);
            $this->viewData["rol_est_ACT"] = $this->viewData["rol_est"] === "ACT" ? "selected": "";
            $this->viewData["rol_est_CREDIT"] = $this->viewData["rol_est"] === "INA" ? "selected": "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["rol_dsc"],
                $this->viewData["rol_id"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/rol", $this->viewData);
    }
}

?>
