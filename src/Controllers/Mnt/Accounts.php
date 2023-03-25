<?php

namespace Controllers\Mnt;
use Controllers\PublicController;
use Views\Renderer;

class Accounts  extends PublicController{

  
    public function run():void{

        $viewData = array();
        $viewData["accounts"]=\Dao\Mnt\Accounts::getAll();
        Renderer::render("mnt/accounts",$viewData);
    }
}

?>