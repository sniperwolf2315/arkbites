<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class Util {
    /**
     * Elimina un directorio de manera recursiva
     */
    public static function eliminar_directorio($dir) {
        $files = scandir($dir);
        array_shift($files);    
        array_shift($files);    
       
        foreach ($files as $file) {
            $file = $dir . '/' . $file;
            if (is_dir($file)) {
                rmdir_recursive($file);
                rmdir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir);
    }
}
?>
