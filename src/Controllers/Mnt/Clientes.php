<?php
/**
 * Archivo Controlador de Categorias el Listado
 */
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

/**
 * Categorias
 */
class Clientes extends PublicController {
    /**
     * Handles Categorias Request
     *
     * @return void
     */
    public function run() :void
    {
        $viewData = array(
            "edit_enabled"=>true,
            "delete_enabled"=>true,
            "new_enabled"=>true
        );
        $viewData["categorias"] = \Dao\Mnt\Clientes::findAll();
        Renderer::render('mnt/clientes', $viewData);
    }
}
?>
