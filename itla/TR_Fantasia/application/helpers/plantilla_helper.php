<?php

/**
 *
 */
class plantilla {
  public static $instancia;
  public static function aplicar(){

    self::$instancia = new plantilla();
  }

  public function __construct(){
    $CI =& get_instance();
    $CI -> load ->view('plantilla/encabezado');
  }

  public function __destruct(){
    $CI =& get_instance();
    $CI -> load ->view('plantilla/pie');
  }

}


 ?>
