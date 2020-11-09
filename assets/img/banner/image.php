<?php
/**
 * Crea un thumbail de una imagen con el ancho y el alto pasados como parámetros. Si se pone el
 * ancho o el alto a 0, este se calculara para que la imagen conserve las proporciones originales.
 *
 * @param type $nombreImagen Nombre completo de la imagen incluida la ruta y la extension.
 * @param type $nombreThumbnail Nombre completo para el thumbnail incluida la ruta y la extension.
 * @param type $nuevoAncho Ancho para el thumbnail.
 * @param type $nuevoAlto Alto para el thumbnail.
 */

//crearThumbnail('crud_empleados.png', 'crud_empleados_thumb.png', 200, 200);

function crearThumbnail($nombreImagen, $nombreThumbnail, $nuevoAncho, $nuevoAlto){

    // Obtiene las dimensiones de la imagen.
    list($ancho, $alto) = getimagesize($nombreImagen);

    // Establece el alto para el thumbnail si solo se paso el ancho.
    if ($nuevoAlto == 0 && $nuevoAncho != 0){
        $factorReduccion = $ancho / $nuevoAncho;
        $nuevoAlto = $alto / $factorReduccion;
    }

    // Establece el ancho para el thumbnail si solo se paso el alto.
    if ($nuevoAlto != 0 && $nuevoAncho == 0){
        $factorReduccion = $alto / $nuevoAlto;
        $nuevoAncho = $ancho / $factorReduccion;
    }

    // Abre la imagen original.
    list($imagen, $tipo) = abrirImagen($nombreImagen);

    // Crea la nueva imagen (el thumbnail).
    $thumbnail = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
    imagecopyresampled($thumbnail , $imagen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

    // Guarda la imagen.
    guardarImagen($thumbnail, $nombreThumbnail, $tipo);
}


/**
 * Crea un thumbail de un imagen con el ancho y el alto pasados como parametros,
 * pero manteniendo las proporciones originales añadiendo bordes a la imagen.
 *
 * @param type $nombreImagen Nombre completo de la imagen incluida la ruta y la extension.
 * @param type $nombreThumbnail Nombre completo para el thumbnail incluida la ruta y la extension.
 * @param type $nuevoAncho Ancho para el thumbnail.
 * @param type $nuevoAlto Alto para el thumbnail.
 */


//crearThumbnail2('crud_empleados.png', 'crud_empleados_thumb.png', 250, 200);
function crearThumbnail2($nombreImagen, $nombreThumbnail, $nuevoAncho, $nuevoAlto){

    // Obtiene las dimensiones de la imagen.
    list($ancho, $alto) = getimagesize($nombreImagen);

    // Comprueba que medida es menor para ponerle luego bordes.
    if ($ancho > $alto){
        $anchoImagen = $nuevoAncho;
        $factorReduccion = $ancho / $nuevoAncho;
        $altoImagen = $alto / $factorReduccion;
    }
    else{
        $altoImagen = $nuevoAlto;
        $factorReduccion = $alto / $nuevoAlto;
        $anchoImagen = $ancho / $factorReduccion;
    }

    // Abre la imagen original.
    list($imagen, $tipo)= abrirImagen($nombreImagen);

    // Crea la nueva imagen (el thumbnail).
    $thumbnail = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
    imagecopyresampled($thumbnail , $imagen, ($nuevoAncho-$anchoImagen)/2, ($nuevoAlto-$altoImagen)/2, 0, 0, $anchoImagen, $altoImagen, $ancho, $alto);

    // Guarda la imagen.
    guardarImagen($thumbnail, $nombreThumbnail, $tipo);
}

/**
 * Crea un thumbail de un imagen con el ancho y el alto pasados como parametros,
 * recortando en caso de ser necesario la dimension mas grande por ambos lados.
 *
 * @param type $nombreImagen Nombre completo de la imagen incluida la ruta y la extension.
 * @param type $nombreThumbnail Nombre completo para el thumbnail incluida la ruta y la extension.
 * @param type $nuevoAncho Ancho para el thumbnail.
 * @param type $nuevoAlto Alto para el thumbnail.
 */

 crearThumbnailRecortado('demo.png', 'demo_thumb.png', 250, 200);
function crearThumbnailRecortado($nombreImagen, $nombreThumbnail, $nuevoAncho, $nuevoAlto){

    // Obtiene las dimensiones de la imagen.
    list($ancho, $alto) = getimagesize($nombreImagen);

    // Si la division del ancho de la imagen entre el ancho del thumbnail es mayor
    // que el alto de la imagen entre el alto del thumbnail entoces igulamos el
    // alto de la imagen  con el alto del thumbnail y calculamos cual deberia ser
    // el ancho para la imagen (Seria mayor que el ancho del thumbnail).
    // Si la relacion entre los altos fuese mayor entonces el altoImagen seria
    // mayor que el alto del thumbnail.
    if ($ancho/$nuevoAncho > $alto/$nuevoAlto){
        $altoImagen = $nuevoAlto;
        $factorReduccion = $alto / $nuevoAlto;
        $anchoImagen = $ancho / $factorReduccion;
    }
    else{
        $anchoImagen = $nuevoAncho;
        $factorReduccion = $ancho / $nuevoAncho;
        $altoImagen = $alto / $factorReduccion;
    }

    // Abre la imagen original.
    list($imagen, $tipo)= abrirImagen($nombreImagen);

    // Crea la nueva imagen (el thumbnail).
    $thumbnail = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

    // Si la relacion entre los anchos es mayor que la relacion entre los altos
    // entonces el ancho de la imagen que se esta creando sera mayor que el del
    // thumbnail porlo que se centrara para que se corte por la derecha y por la
    // izquierda. Si el alto fuese mayor lo mismo se cortaria la imagen por arriba
    // y por abajo.
    if ($ancho/$nuevoAncho > $alto/$nuevoAlto){
        imagecopyresampled($thumbnail , $imagen, ($nuevoAncho-$anchoImagen)/2, 0, 0, 0, $anchoImagen, $altoImagen, $ancho, $alto);
    }  else {
        imagecopyresampled($thumbnail , $imagen, 0, ($nuevoAlto-$altoImagen)/2, 0, 0, $anchoImagen, $altoImagen, $ancho, $alto);
    }

    // Guarda la imagen.
    guardarImagen($thumbnail, $nombreThumbnail, $tipo);
}


/**
 * Abre la imagen con el nombre pasado como parametro y devuelve un array con la imagen y el tipo de imagen.
 *
 * @param type $nombre Nombre completo de la imagen incluida la ruta y la extension.
 * @return Devuelve la imagen abierta.
 */

function abrirImagen($nombre){
    $info = getimagesize($nombre);
    switch ($info["mime"]){
        case "image/jpeg":
            $imagen = imagecreatefromjpeg($nombre);
            break;
        case "image/gif":
            $imagen = imagecreatefromgif($nombre);
            break;
        case "image/png":
            $imagen = imagecreatefrompng($nombre);
            break;
        default :
            echo "Error: No es un tipo de imagen permitido.";
    }
    $resultado[0]= $imagen;
    $resultado[1]= $info["mime"];
    return $resultado;
}

/**
 * Guarda la imagen con el nombre pasado como parametro.
 *
 * @param type $imagen La imagen que se quiere guardar
 * @param type $nombre Nombre completo de la imagen incluida la ruta y la extension.
 * @param type $tipo Formato en el que se guardara la imagen.
 */

function guardarImagen($imagen, $nombre, $tipo){

    switch ($tipo){
        case "image/jpeg":
            imagejpeg($imagen, $nombre, 100); // El 100 es la calidade de la imagen (entre 1 y 100. Con 100 sin compresion ni perdida de calidad.).
            break;
        case "image/gif":
            imagegif($imagen, $nombre);
            break;
        case "image/png":
            imagepng($imagen, $nombre, 9); // El 9 es grado de compresion de la imagen (entre 0 y 9. Con 9 maxima compresion pero igual calidad.).
            break;
        default :
            echo "Error: Tipo de imagen no permitido.";
    }
}


?>
