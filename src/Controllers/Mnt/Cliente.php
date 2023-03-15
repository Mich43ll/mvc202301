<?php
namespace Controllers\Mnt;

use Views\Renderer;
use Controllers\PublicController;
use Exception;
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
class Categoria extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Categorias";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "clientid" => 0,
        "clientname" => "",
        "clientgender" => "",
        "clientgender_MAS" => "selected",
        "clientgender_FEM" => "",
        "clientphone1" => "",
        "clientphone2" => "",
        "clientemail" => "",
        "clientIdnumber" => "",
        "clientbio" => "",
        "clientstatus" => "ACT",
        "clientstatus_ACT" => "selected",
        "clientstatust_INA" => "",
        "clientname_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
        "xssToken" =>""
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nueva Categoría",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Borrar %s (%s)"
    );
    public function run() :void
    {
        try {
            $this->page_loaded();
            if($this->isPostBack()){
                $this->validatePostData();
                if(!$this->viewData["has_errors"]){
                    $this->executeAction();
                }
            }
            $this->render();
        } catch (Exception $error) {
            unset($_SESSION["xssToken_Mnt_Categoria"]);
            error_log(sprintf("Controller/Mnt/Categoria ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg(
                $this->redirectTo,
                "Algo Inesperado Sucedió. Intente de Nuevo."
            );
        }
        /*
        1) Captura de Valores Iniciales QueryParams -> Parámetros de Query ? 
            https://ax.ex.com/index.php?page=abc&mode=UPD&id=1029
        2) Determinamos el método POST GET
        3) Procesar la Entrada
            3.1) Si es un POST
            3.2) Capturar y Validara datos del formulario
            3.3) Según el modo realizar la acción solicitada
            3.4) Notificar Error si hay
            3.5) Redirigir a la Lista
            4.1) Si es un GET
            4.2) Obtener valores de la DB sin no es INS
            4.3) Mostrar Valores
        4) Renderizar
        */

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
        if(isset($_POST["xssToken"])){
            if(isset($_SESSION["xssToken_Mnt_Cliente"])){
                if($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Cliente"]){
                    throw new Exception("Invalid Xss Token no match");
                }
            } else {
                throw new Exception("Invalid Xss Token on Session");
            }
        } else {
            throw new Exception("Invalid Xss Token");
        }
        if(isset($_POST["clientname"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientname"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["clientname_error"] = "El nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("clientname not present in form");
        }

        if(isset($_POST["clientphone1"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientphone1"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["clientphone1_error"] = "El nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("clientphone1 not present in form");
        }

        if(isset($_POST["clientphone2"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientphone2"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["clientphone2_error"] = "El nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("clientphone2 not present in form");
        }

        if(isset($_POST["clientemail"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientemail"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["clientemail_error"] = "El nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("clientemail not present in form");
        }

        if(isset($_POST["clientIdnumber"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientIdnumber"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["clientIdnumber_error"] = "El nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("clientIdnumber not present in form");
        }

        if(isset($_POST["clientbio"])){
            if(\Utilities\Validators::IsEmpty($_POST["clientbio"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["clientbio_error"] = "El nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("clientbio not present in form");
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
        $this->viewData["clientname"] = $_POST["clientname"];
        $this->viewData["clientgender"] = $_POST["clientgender"];
        $this->viewData["clientphone1"] = $_POST["clientphone1"];
        $this->viewData["clientphone2"] = $_POST["clientphone2"];
        $this->viewData["clientemail"] = $_POST["clientemail"];
        $this->viewData["clientIdnumber"] = $_POST["clientIdnumber"];
        $this->viewData["clientbio"] = $_POST["clientbio"];
        $this->viewData["clientstatus"] = $_POST["clientstatus"];
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["clientstatus"] = $_POST["clientstatus"];
        }
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Categorias::insert(
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
                        "Categoría Creada Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Categorias::update(
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
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Categoría Actualizada Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Categorias::delete(
                    $this->viewData["clientid"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Categoría Eliminada Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        $xssToken = md5("CATEGORIA" . rand(0,4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Categoria"] = $xssToken;

        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpClientes = \Dao\Mnt\Clientes::findById($this->viewData["clientid"]);
            if(!$tmpClientes){
                throw new Exception("Categoria no existe en DB");
            }
            //$this->viewData["catnom"] = $tmpClientes["catnom"];
            //$this->viewData["catest"] = $tmpClientes["catest"];
            \Utilities\ArrUtils::mergeFullArrayTo($tmpClientes, $this->viewData);
            $this->viewData["clientgender_MAS"] = $this->viewData["clientgender"] === "MAS" ? "selected": "";
            $this->viewData["clientgender_FEM"] = $this->viewData["clientgender"] === "FEM" ? "selected": "";
            $this->viewData["clientstatus_ACT"] = $this->viewData["clientstatus"] === "ACT" ? "selected": "";
            $this->viewData["clientstatust_INA"] = $this->viewData["clientstatus"] === "INA" ? "selected": "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["clientname"],
                $this->viewData["clientid"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/categoria", $this->viewData);
    }
}

?>
