<?php

namespace Controllers\Mnt;
use Controllers\PublicController;
use Views\Renderer;

class Roles  extends PublicController{

  
    public function run():void{

        $viewData = array();
        $viewData["roles"]=\Dao\Mnt\Roles::getAll();
        Renderer::render("mnt/roles",$viewData);
    }
}

?>