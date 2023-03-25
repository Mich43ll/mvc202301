<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;
/*
`journal_id` BIGINT(8) NOT NULL AUTO_INCREMENT,
`catnom` VARCHAR(45) NULL,
`catest` CHAR(3) NULL DEFAULT 'ACT',
*/
class Cliente extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Clientes";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "clientname" =>"",
        "clientgender"=> "MAS",
        "clientgender_MAS"=> "selected",
        "clientgender_FEM"=> "",
        "clientphone1" => "",
        "clientphone2" => "",
        "clientemail" => "",
        "clientIdnumber" => "",
        "clientbio" => "",
        "clientstatus" => "ACT",
        "clientstatus_ACT" => "selected",
        "clientstatus_INA" => "",
        "clientid" => 0,
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Cliente",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Borrar %s (%s)"
    );
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
            if(isset($_GET['clientid'])){
                $this->viewData["clientid"] = intval($_GET["clientid"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }
    private function validatePostData(){
        if(isset($_POST["clientname"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientname"])){
                $this->viewData["has_errors"] = true;
            }
        } else {
            throw new Exception("clientname not present in form");
        }

        if(isset($_POST["clientgender"])){
            if (!in_array( $_POST["clientgender"], array("MAS","FEM"))){
                throw new Exception("clientgender incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("clientgender not present in form");
            }
        }

        if(isset($_POST["clientstatus"])){
            if (!in_array( $_POST["clientstatus"], array("ACT","INA"))){
                throw new Exception("clientstatus incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("clientstatus not present in form");
            }
        }

        if(isset($_POST["clientphone1"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientphone1"])){
                throw new Exception ("Phone  incorrect value");
            }
        }
        
        if(isset($_POST["clientphone2"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientphone2"])){
                throw new Exception ("Phone 2  incorrect value");
            }
        }

        if(isset($_POST["clientemail"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientemail"])){
                throw new Exception ("Email incorrect value");
            }
        }

        if(isset($_POST["clientIdnumber"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientIdnumber"])){
                throw new Exception ("Client id incorrect value");
            }
        }

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
        if(isset($_POST["clientid"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["clientid"])<=0)){
                throw new Exception("clientid is not Valid");
            }
            if($this->viewData["clientid"]!== intval($_POST["clientid"])){
                throw new Exception("clientid value is different from query");
            }
        }else {
            throw new Exception("clientid not present in form");
        }
        $tmpPostName = array("clientname" =>$_POST["clientname"],
        "clientgender"=> $_POST["clientgender"],
        "clientphone1" => $_POST["clientphone1"],
        "clientphone2" => $_POST["clientphone2"],
        "clientemail" => $_POST["clientemail"],
        "clientIdnumber" => $_POST["clientIdnumber"],
        "clientbio" => $_POST["clientbio"],
        "clientstatus" => $_POST["clientstatus"]);

        \Utilities\ArrUtils::mergeFullArrayTo($tmpPostName, $this->viewData
        );
        
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["clientid"] = $_POST["clientid"];
        }
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Clientes::insert(
                    $this->viewData["clientname"],
                    $this->viewData["clientgender"],
                    $this->viewData["clientphone1"],
                    $this->viewData["clientphone2"],
                    $this->viewData["clientemail"],
                    $this->viewData["clientIdnumber"],
                    $this->viewData["clientbio"],
                    $this->viewData["clientstatus"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cliente Creado Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Clientes::update(
                    $this->viewData["clientid"],
                    $this->viewData["clientname"],
                    $this->viewData["clientgender"],
                    $this->viewData["clientphone1"],
                    $this->viewData["clientphone2"],
                    $this->viewData["clientemail"],
                    $this->viewData["clientIdnumber"],
                    $this->viewData["clientbio"],
                    $this->viewData["clientstatus"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cliente Actualizado Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Clientes::delete(
                    $this->viewData["clientid"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cliente Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){

        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpCliente = \Dao\Mnt\Journals::getById($this->viewData["clientid"]);
            if(!$tmpCliente){
                throw new Exception("Cliente no existe en DB");
            }
            //$this->viewData["catnom"] = $tmpCliente["catnom"];
            //$this->viewData["catest"] = $tmpCliente["catest"];
            \Utilities\ArrUtils::mergeFullArrayTo($tmpCliente, $this->viewData);
            $this->viewData["clientgender_MAS"] = $this->viewData["clientgender"] === "MAS" ? "selected": "";
            $this->viewData["clientgender_FEM"] = $this->viewData["clientgender"] === "FEM" ? "selected": "";
            $this->viewData["clientstatus_ACT"] = $this->viewData["clientstatus"] === "ACT" ? "selected": "";
            $this->viewData["clientstatus_INA"] = $this->viewData["clientstatus"] === "INA" ? "selected": "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                    $this->viewData["clientname"],
                    $this->viewData["clientgender"],
                    $this->viewData["clientphone1"],
                    $this->viewData["clientphone2"],
                    $this->viewData["clientemail"],
                    $this->viewData["clientIdnumber"],
                    $this->viewData["clientbio"],
                    $this->viewData["clientstatus"],
                    $this->viewData["clientid"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/cliente", $this->viewData);
    }
}

?>
