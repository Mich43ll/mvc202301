<?php

namespace Controllers\NW202301;

use Controllers\PublicController;
use Views\Renderer;

class MiFicha extends PublicController{
    
    public function run(): void
    {
        $viewData =  array(
            "nombre" => "Michaell Osorio",
            "email" => "mosoriobarahona@gmail.com",
            "title" => "software Engineer"
        );
        Renderer::render("nw202301/miFicha", $viewData);

    }
}

?>