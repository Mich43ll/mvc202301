<?php
    namespace Controllers;

    use Controllers\PublicController;
    use Views\Renderer;

    class Funcion extends PublicController{
        private $redirectTo:"index.php?page=Mnt-Funciones";
        private $viewData = array(
            "mode"=> "DSP",
            "modedsc"=>"",
            "fncod" =>"",
            "fndsc" =>"",
            "fnest"=>"ACT",
            "fnest_ACT"=>"selected",
            "fnest_INA"=>"",
            "fntyp"=>"ABC",
            "fntyp_ABC"=>"selected",
            "fntyp_XYZ"=>"",
            "fncod_error"=>"",
            "fndsc_error"=>"",
            "general_errors"=>array(),
            "has_errors"=>false,
            "show_action"=>true,
            "readonly"=>false,
            "xssToken"=>""
        );
        private $modes = array(
            "DSP"=>"Detalle de %s (%s)",
            "INS"=>"Nueva Funcion",
            "UPD"=>"Editar %s (%s)",
            "DEL"=>"Borrar %s (%s)",
        );
        public function run() :void
        {
            try{
                $this->page_loaded();
                if($this->isPostBack()){
                    $this->validatePostData();
                    if($this->viewData["has_errors"]){
                        $this->executeAction();
                    }
                }
                $this->render();
            } 
                catch(Exception $error) {
                    unset($_SESSION["xssToken_Mnt_Funcion"]);
                    error_log(sprintf("Controllers/Mnt/Funcion ERROR: %s", $error->getMessage));
                    \Utilities\Sites::redirectToWithMsg(
                        $redirectTo,
                        "Algo Inesperado Sucedió. Intente de Nuevo"
                    )
                }
        }
        private function page_loaded()
        {
            if(isset($_GET['mode'])){
                if(isset($this->modes[$_GET['mode']])){
                    $this->viewData["mode"] = $_Get['mode'];
                } else{
                    throw "Mode Not available";
                }
            } else{
                throw "Mode Not Defined on Query Params"
            }
            if($this->viewData["mode"] !== "INS"){
            if(isset($_GET('fncod'))){
                $this->viewData["fncod"] = strval($_Get["fncod"]);
            }
        }
        }
        private function validatePostData(){
            if(isset($_POST["xssToken"])){
                if(isset($_SESSION["xssToken_Mnt_Funcion"])){
                    if($_POST["xssToken"]!==$_SESSION["xssToken_Mnt_Funcion"]){
                        throw new Exception("Invalid Xss Token no match");
                    }
                } else {
                    throw new Exception("Invalid Xss Token on Session");
                }
            }else{
                throw new Exception("Invalid Xss Token");
            }
            if(isset($_POST["fndsc"])){
                if(\Utilities\Validators::IsEmpty($_POST["fndsc"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["fndsc_error"]= "Este campo no puede ir vacio";
                }

            } else{
                throw new Exception{"FnDsc not presented in form"};
            }
            if(isset($_POST["fnest"])){
                if(!in_array($_POST["fnest"],array("ACT","INA"))){
                    throw new Exception{"FnEst Inncorrect Value"};    
                }               
            }else{
                throw new Exception{"FnEst not presented in form"};
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("FnEst not present in form");
                }
            }
            if(isset($_POST["fntyp"])){
                if(!in_array($_POST["fntyp"],array("ABC","XYZ"))){
                    throw new Exception{"FnTyp Inncorrect Value"};    
                }               
            }else{
                throw new Exception{"FnTyp not presented in form"};
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("FnTyp not present in form");
                }
            }
            if(isset($_POST["mode"])){
                if(!key_exists($_POST["mode"], $this->modes)){
                    throw new Exception{"Mode has a bad value"};
                }
                if($this->viewData["mode"]!==$_POST["mode"]){
                    throw new Exception{"Mode value is diffrent from query"};
                }                
            }else{
                throw new Exception{"Mode not presented in form"};
            }
            if(isset($_POST["fncod"])){
                if(\Utilities\Validators::IsEmpty($_POST["fncod"])){
                    $this->viewData["has_errors"]= true;
                    $this->viewData["fncod_error"]= "El codigo no puede ir vacio!";
                }
            } else{
                throw new Exception{"FnCod not presented in form"};
            }
            $this->viewData["fndsc"]= $_POST["fndsc"];
            $this->viewData["fnest"]= $_POST["fnest"];
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["fnest"] = $_POST["fnest"];
            }
            $this->viewData["fntyp"]= $_POST["fntyp"];
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["fntyp"] = $_POST["fntyp"];
            }
            $this->viewData["fncod"]= $_POST["fncod"];
        }
        private function executeAction(){
            switch($this->viewData["mode"]){
                case "INS":
                    $inserted=\Dao\Mnt\Funciones::insert(
                        $this->viewData["fncod"],
                        $this->viewData["fndsc"],
                        $this->viewData["fnest"],
                        $this->viewData["fntyp"]
                    );
                    if($inserted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Funcion Creada Exitosamente"                        
                        );
                    }
                    break;
                case "UPD":
                    $updated=\Dao\Mnt\Roles::insert(
                        $this->viewData["fncod"],
                        $this->viewData["fndsc"],
                        $this->viewData["fnest"],
                        $this->viewData["fntyp"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Funcion Actualizada Exitosamente"                        
                        );
                    }
                    break;
                case "DEL":
                    $deleted=\Dao\Mnt\Roles::insert(
                        $this->viewData["fncod"]
                    );
                    if($deleted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Funcion Eliminada Exitosamente"                        
                        );
                    }
                    break;
            }
        }
        private function render(){
            $xssToken=md5("FUNCIONES". rand(0,4000)*rand(5000*9999));
            $this->viewData["xssToken"]=$xssToken;
            $_SESSION["xssToken_Mnt_Funcion"]=$xssToken;
            if($this->viewData["mode"] === "INS") {
                $this->viewData["modedsc"] = $this->modes["INS"];
            } else {
                $tmpFunciones = \Dao\Mnt\Funciones::findById($this->viewData["fncod"]);
                if(!$tmpFunciones){
                    throw new Exception("Funcion no existe en DB");
                }
                \Utilities\ArrUtils::mergeFullArrayTo($tmpFunciones, $this->viewData);
                $this->viewData["fnest_ACT"] = $this->viewData["fnest"] === "ACT" ? "selected": "";
                $this->viewData["fnest_INA"] = $this->viewData["fnest"] === "INA" ? "selected": "";
                $this->viewData["fntyp_ABC"] = $this->viewData["fntyp"] === "ABC" ? "selected": "";
                $this->viewData["fntyp_XYZ"] = $this->viewData["fntyp"] === "XYZ" ? "selected": "";
                $this->viewData["modedsc"] = sprintf(
                    $this->modes[$this->viewData["mode"]],
                    $this->viewData["fndsc"],
                    $this->viewData["fncod"]
                );
                if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                    $this->viewData["readonly"] = "readonly";
                }
                if($this->viewData["mode"] === "DSP") {
                    $this->viewData["show_action"] = false;
                }
            }
            Renderer::render("mnt/funciones", $this->viewData);
    }
}
?>