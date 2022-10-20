<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

    include("_check_login.php");
    require_once("../../include/arkabytes/bbdd.php");

    include("../../include/pChart2.1.4/class/pDraw.class.php");
    include("../../include/pChart2.1.4/class/pBarcode128.class.php");
    include("../../include/pChart2.1.4/class/pImage.class.php");
    
    $id = $_REQUEST["id"];
    $id = sprintf("%06s", $id);
    
    $barcode = new pBarcode128("../../include/pChart2.1.4/");
    $settings = array("ShowLegend"=>TRUE, "DrawArea"=>TRUE);
    $size = $barcode->getSize($id, $settings);
    
    $picture = new pImage($size["Width"], $size["Height"]);
    $picture->setFontProperties(array("FontName"=>"../../include/pChart2.1.4/fonts/GeosansLight.ttf"));
    
    $barcode->draw($picture, $id, 10, 10, $settings);
    $picture->autoOutput("../articulos/codigo.png");
?>
