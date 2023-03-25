<?php

namespace Controllers\Mnt;
use Controllers\PublicController;
use Views\Renderer;

class Funciones extends PublicController{
    public function run():void{
        $viewData = array();
        $viewData["funciones"]=\Dao\Mnt\Funciones::getAll();
        Renderer::render("mnt/funciones",$viewData);
    }
}