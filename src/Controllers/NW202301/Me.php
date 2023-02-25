<?php
namespace Controllers\NW202301;

use Controllers\PublicController;
use Views\Renderer;

class Me extends PublicController{
///mvc202301/index.php?page=nw202301-Me  instancia para ingresar al namespace de la view
    public function run(): void
    {
        $viewData = array();
        Renderer::render('nw202301/me',$viewData);
    }
}


?>