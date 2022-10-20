<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class Imagenes {

	/**
	 * Redimensiona una imagen para generar una miniatura
	 * @param unknown $ruta_imagen
	 */
    public static function redimensionar_imagen($ruta_imagen) {
        
    	// Mantiene la proporción de la imagen
    	$x = 94;
    	$ratio = 0;
    	$tamano = getimagesize($ruta_imagen);
    	$ratio = floatval($tamano[0] / $tamano[1]);
    	$y = $x / $ratio;
    	
    	$extension = Imagenes::get_extension($ruta_imagen);
    	if (($extension == "jpg") || ($extension == "jpeg")) 
    		$imagen = ImageCreateFromJPEG($ruta_imagen);
    	else if (($extension == "png"))
    		$imagen = ImageCreateFromPNG($ruta_imagen);
    	else
    		$imagen = imagecreatefromgif($ruta_imagen);
        
        $nueva_imagen = imagecreatetruecolor($x, $y);
        ImageCopyResized($nueva_imagen, $imagen, 0, 0, 0, 0, $x, $y, imagesx($imagen), imagesy($imagen));
        ImageJPEG($nueva_imagen, $ruta_imagen, 100);
        ImageDestroy($imagen);
    }
    
    /**
     * Devuelve la extensión de un fichero
     * @param unknown $ruta_imagen
     * @return string
     */
    public static function get_extension($ruta_imagen) {
    	
    	$posicion = strrpos($ruta_imagen, ".");
    	$extension = substr($ruta_imagen, $posicion + 1, strlen($ruta_imagen));
    	
    	return strtolower($extension);
    }
}
?>
