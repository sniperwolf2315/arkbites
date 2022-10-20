<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

    require("../config/abc-config.php");
    require("../include/arkabytes/bbdd.php");
    
    session_start();
    session_unset();
    session_destroy();
    header("location: " . BASE_URL . "?id=login");
?>
