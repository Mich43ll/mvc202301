<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Dao\Dao;
use Views\Renderer;

class Categorias extends PublicController{
    public function run():void{
        $viewData =  array();
        $viewData['categorias'] = \Dao\Mnt\Categorias::findAll();
        Renderer::render('mnt/categorias',$viewData);
    }
}
?>