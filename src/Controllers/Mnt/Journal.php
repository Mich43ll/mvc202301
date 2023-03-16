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
class Journal extends PublicController{
    private $redirectTo = "index.php?page=Mnt_Journals";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "journal_id" => 0,
        "journal_date" => "",
        "journal_type" => "DEBIT",
        "journal_type_DEBIT" => "selected",
        "journal_type_CREDIT" => "",
        "journal_description" => "",
        "journal_amount" => 0,
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
        "xssToken" =>""
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Journal",
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
            unset($_SESSION["xssToken_Mnt_Journal"]);
            error_log(sprintf("Controller/Mnt/Journal ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg(
                $this->redirectTo,
                "Algo Inesperado Sucedió. Intente de Nuevo."
            );
        }

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
            if(isset($_GET['journal_id'])){
                $this->viewData["journal_id"] = intval($_GET["journal_id"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }
    private function validatePostData(){
        if(isset($_POST["xssToken"])){
            if(isset($_SESSION["xssToken_Mnt_Journal"])){
                if($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Journal"]){
                    throw new Exception("Invalid Xss Token no match");
                }
            } else {
                throw new Exception("Invalid Xss Token on Session");
            }
        } else {
            throw new Exception("Invalid Xss Token");
        }
        if(isset($_POST["journal_description"])){
            if(\Utilities\Validators::IsEmpty($_POST["journal_description"])){
                $this->viewData["has_errors"] = true;
            }
        } else {
            throw new Exception("journal_description not present in form");
        }
        if(isset($_POST["journal_type"])){
            if (!in_array( $_POST["journal_type"], array("DEBIT","CREDIT"))){
                throw new Exception("journal_type incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("journal_type not present in form");
            }
        }

        if(isset($_POST["journal_amount"])){
            if(floatval($_POST["journal_amount"])<=0){
                throw new Exception ("Journal amount incorrect value");
            }else {
                throw new Exception("amount not present in form");
            }
        }

        if(isset($_POST["journal_date"])){
            if(\Utilities\Validators::IsEmpty($_POST["journal_date"])){
                throw new Exception ("Journal Date incorrect value");
            }else {
                throw new Exception("date not present in form");
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
        if(isset($_POST["journal_id"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["journal_id"])<=0)){
                throw new Exception("journal_id is not Valid");
            }
            if($this->viewData["journal_id"]!== intval($_POST["journal_id"])){
                throw new Exception("journal_id value is different from query");
            }
        }else {
            throw new Exception("journal_id not present in form");
        }
        $tmpPostDate = array("journal_date" => $_POST["journal_date"],
        "journal_description" => $_POST["journal_description"],
        "journal_amount" =>floatval( $_POST["journal_amount"]));

        \Utilities\ArrUtils::mergeFullArrayTo($tmpPostDate, $this->viewData
        );
        
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["journal_type"] = $_POST["journal_type"];
        }
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Journals::insert(
                    $this->viewData["journal_description"],
                    $this->viewData["journal_type"],
                    $this->viewData["journal_date"],
                    $this->viewData["journal_amount"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Journal Creada Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Journals::update(
                    $this->viewData["journal_description"],
                    $this->viewData["journal_type"],
                    $this->viewData["journal_date"],
                    $this->viewData["journal_amount"],
                    $this->viewData["journal_id"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Journal Actualizada Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Journals::delete(
                    $this->viewData["journal_id"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Journal Eliminada Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        $xssToken = md5("JOURNAL" . rand(0,4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Journal"] = $xssToken;

        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpJournal = \Dao\Mnt\Journals::getById($this->viewData["journal_id"]);
            if(!$tmpJournal){
                throw new Exception("Journal no existe en DB");
            }
            //$this->viewData["catnom"] = $tmpJournal["catnom"];
            //$this->viewData["catest"] = $tmpJournal["catest"];
            \Utilities\ArrUtils::mergeFullArrayTo($tmpJournal, $this->viewData);
            $this->viewData["journal_type_DEBIT"] = $this->viewData["journal_type"] === "DEBIT" ? "selected": "";
            $this->viewData["journal_type_CREDIT"] = $this->viewData["journal_type"] === "CREDIT" ? "selected": "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["journal_date"],
                $this->viewData["journal_id"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/journal", $this->viewData);
    }
}

?>
