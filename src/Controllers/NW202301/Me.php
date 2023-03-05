<?php
namespace Controllers\NW202301;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Clases\Demo;

class Me extends PublicController{
///mvc202301/index.php?page=nw202301-Me  instancia para ingresar al namespace de la view
    public function run(): void
    {
        $viewData = array();
        $responseDao = Demo::getResponse()[0]["Response"];
        $viewData["response"]=$responseDao;
        Renderer::render('nw202301/me',$viewData);
    }
}


?>