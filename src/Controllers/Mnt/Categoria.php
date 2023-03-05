<?php

namespace Controllers\PublicController;

use Exeption;
use Controllers\PublicController;
use Exception;
use FFI\Exception as FFIException;

class Categoria extends PublicController
{
    private $redirectTo = "index.php?page=Mnt-Categorias";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "catid" => 0,
        "catnom" => "",
        "catest" => "ACT",
        "catest_ACT" => "selected",
        "catest_INI" => "",
        "catnom_erro" => "",
        "general_errors" => array(),
        "has_errors" => false
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nueva Categoria",
        "DEL" => "Borrar %s (%s)",
        "UPD" => "Editar %s (%s)"
    );
    public function run(): void
    {
        try {
            $this->page_loaded();
            if ($this->isPostBack()) {
                $this->validatePostData();
                if (!$this->viewData["has_errors"]) {
                    $this->executeAction();
                }
            }
            $this->render();
        } catch (Exception $error) {
            error_log(sprintf("Controller/Mnt/Categoria ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg($this->redirectTo, "Algo inesperado sucedio. Intente de Nuevo");
        }
    }
    /*
        1) Captura de Valores Iniciales QueryParams -> Parametros de Query ? 
            https://ax.ex.com/index.php?page=abc&mode=UPD&id=1029 -> QueryParam es todo lo que se encuentra despues del ?
        2) Determinamos el metodo: POST GET
        3) Procesar la Entrada
            3.1) Si es un POST
            3.2) Capturar y validara datos del formulario 
            3.3) Segun el modo realizar la accions solicitada 
            3.4) Notificar Errar si hay 
            3.5) Redirigir a la lista 
            4.1) Si es un GET
            4.2) Obtener valores de la DB sin no es INS
            4.3) Mostrar valores 
        4) Renderizar
        */


    private function page_loaded()
    {
        if (isset($_GET['mode'])) {
            if (isset($this->modes[$_GET['mode']])) {
                $this->viewData["mode"] = $_GET['mode'];
            } else {
                throw new Exception("Mode Not available");
            }
        } else {
            throw new Exception("Mode Not defined on Query Params");
        }
        if ($this->viewData["mode"] !== "INS") {
            if (isset($_GET['catid'])) {
                $this->viewData["catid"] = intval($_GET['catid']);
            } else {
                throw new FFIException("Id not found on Query Params");
            }
        }
    }

    private function validatePostData()
    {
        if (isset($_POST["catnom"])) {
            if (\Utilities\Validators::IsEmpty($_POST["catnom"])) {
                $this->viewData["has_errors"] = true;
                $this->viewData["catnom_error"] = "El nombre no puede ir vacio!";
            }
        } else {
            throw new Exception("CatNom not present in form");
        }

        if (isset($_POST["catest"])) {
            if (!in_array($_POST["catest"], array("ACT", "INA"))) {
                throw new Exception("CatEst incorrect value");
            }
        } else {
            throw new Exception("CatEst not present in form");
        }

        if (isset($_POST["mode"])) {
            if (!key_exists($_POST["mode"], $this->modes)) {
                throw new Exception("Mode has a bad value");
            }
            if ($this->viewData["mode"] !== $_POST["mode"]) {
                throw new Exception("Mode has a bad value");
            }
        } else {
            throw new Exception("Mode value is different from query");
        }

        if (isset($_POST["catid"])) {
            if (!$this->viewData["catid"] !== "INS" && intval($_POST["catid"]) > 0) {
                throw new Exception("CatId is not valid");
            }
            if (!$this->viewData["catid"] !== $_POST["catid"]) {
                throw new Exception("CatId value is different from Query");
            }
        } else {
            throw new Exception("CatId not present in form");
        }
        $this->viewData["catnom"] = $_POST["catnom"];
        $this->viewData["catest"] = $_POST["catest"];
    }

    private function executeAction()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                $inserted = \Dao\Mnt\Categorias::insert(
                    $this->viewData["catnom"],
                    $this->viewData["catest"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Categoria Creada Exitosamente"
                    );
                }
                break;

            case "UPD":
                $updated = \Dao\Mnt\Categorias::update(
                    $this->viewData["catnom"],
                    $this->viewData["catest"],
                    $this->viewData["catid"]);
                    if($updated > 0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirectTo,
                            "Categoria Actualizada Exitosamente"
                        );
                    }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Categorias::delete($this->viewData["catid"]);
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Categoria Eliminada Exitosamente"
                    );
                }
                break;
        }
    }

    private function render(){
        
    }
}
