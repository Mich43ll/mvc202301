<?php

namespace Controllers\Mnt;
use Controllers\PublicController;
use Views\Renderer;

class Journals  extends PublicController{
    public function run():void{
        $viewData = array();
        $viewData["journals"]=\Dao\Mnt\Journals::getAll();
        Renderer::render("mnt/journals",$viewData);
    }
}