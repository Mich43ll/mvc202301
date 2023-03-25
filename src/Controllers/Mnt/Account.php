<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Account extends PublicController{

      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private $redirectTo = "index.php?page=Mnt-Accounts";


      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "account_id" => 0,
        "account_name" => "",
        "account_type" => "ASSET",
        "account_type_ASSET" => "selected",
        "account_type_LIABILITY" => "",
        "account_type_EQUITY" => "",
        "account_type_INCOME" => "",
        "account_type_EXPENSE" => "",
        "balance" => 0,
        "created_at" => "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
        
    );

      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nueva Cuenta",
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
            if(isset($_GET['account_id'])){
                $this->viewData["account_id"] = intval($_GET["account_id"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }

        ///////////////////////////////////////////////////////INICIO DE LOS CAMPOS DE LA TABLA JOURNAL///////////////////////////////////////////////////////
        private function validatePostData(){
        if(isset($_POST["account_name"])){
            if(\Utilities\Validators::IsEmpty($_POST["account_name"])){
                $this->viewData["has_errors"] = true;
            }
        } else {
            throw new Exception("journal description not present in form");
        }

        ///////////////////////////////////////////////////////
        if(isset($_POST["account_type"])){
            if (!in_array( $_POST["account_type"], array("ASSET","LIABILITY","EQUITY","INCOME","EXPENSE"))){
                throw new Exception("account_type incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("account_type not present in form");
            }
        }

        ///////////////////////////////////////////////////////
        if(isset($_POST["balance"])){
            if(floatval($_POST["balance"])<=0){
                throw new Exception ("Balance amount incorrect value");
            }
            if(\Utilities\Validators::IsEmpty($_POST["balance"])){
                throw new Exception ("Balance amount is empty");
            }
        }

        ///////////////////////////////////////////////////////
        if(isset($_POST["created_at"])){
            if(\Utilities\Validators::IsEmpty($_POST["created_at"])){
                throw new Exception ("Date incorrect value");
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
        if(isset($_POST["account_id"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["account_id"])<=0)){
                throw new Exception("account_id is not Valid");
            }
            if($this->viewData["account_id"]!== intval($_POST["account_id"])){
                throw new Exception("account_id value is different from query");
            }
        }else {
            throw new Exception("account_id not present in form");
        }

 
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $tmpPostData = array(
                            "account_name" => $_POST["account_name"],
                            "account_type" => $_POST["account_type"],
                            "balance" =>floatval( $_POST["balance"]),
                            "created_at" => $_POST["created_at"]);


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////

        \Utilities\ArrUtils::mergeFullArrayTo($tmpPostData, $this->viewData
        );
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["account_type"] = $_POST["account_type"];
        }
    }


      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Accounts::insert(
                    $this->viewData["account_name"],
                    $this->viewData["account_type"],
                    $this->viewData["balance"],
                    $this->viewData["created_at"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cuenta Creada Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Accounts::update(
                    $this->viewData["account_name"],
                    $this->viewData["account_type"],
                    $this->viewData["balance"],
                    $this->viewData["created_at"],
                    $this->viewData["account_id"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cuenta Actualizada Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Accounts::delete(
                    $this->viewData["account_id"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cuenta Eliminada Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpAccounts = \Dao\Mnt\Accounts::getById($this->viewData["account_id"]);
            if(!$tmpAccounts){
                throw new Exception("Cuenta no existe en DB");
            }
            //$this->viewData["catnom"] = $tmpJournal["catnom"];
            //$this->viewData["catest"] = $tmpJournal["catest"];
            \Utilities\ArrUtils::mergeFullArrayTo($tmpAccounts, $this->viewData);
            $this->viewData["account_type_ASSET"] = $this->viewData["account_type"] === "ASSET" ? "selected": "";
            $this->viewData["account_type_LIABILITY"] = $this->viewData["account_type"] === "LIABILITY" ? "selected": "";
            $this->viewData["account_type_EQUITY"] = $this->viewData["account_type"] === "EQUITY" ? "selected": "";
            $this->viewData["account_type_INCOME"] = $this->viewData["account_type"] === "INCOME" ? "selected": "";
            $this->viewData["account_type_EXPENSE"] = $this->viewData["account_type"] === "EXPENSE" ? "selected": "";

            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["account_name"],
                $this->viewData["account_id"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/account", $this->viewData);
    }
}
