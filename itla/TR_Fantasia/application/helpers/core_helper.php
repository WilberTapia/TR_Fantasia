<?php

/**
 *
 */
class core_crud{

  static function guardar($tabla, $datos){ //create
      $CI =& get_instance();

      if (isset($datos['id']) && $datos['id'] > 0) {
        $CI -> db -> where('id',$datos['id']);
        $CI-> db ->update($tabla, $datos);
      }else {
        $CI -> db -> insert($tabla,$datos);
      }
      //$CI -> db -> insert($tabla, $datos);
  }

  static function guardarF($tabla, $datos){ //create
      $CI =& get_instance();
        $CI -> db -> insert($tabla,$datos);
      //$CI -> db -> insert($tabla, $datos);
  }

  static function listado($tabla) {//read
    $CI =& get_instance();
    $rs = $CI->db->get($tabla)->result();
    return $rs;
  }

  static function x_id($id, $tabla) { //read
    $CI =& get_instance();
    $CI ->db->where('id',$id);
    $rs = $CI->db->get($tabla)->result();
    return $rs;
  }

  static function x_id_factura($id, $tabla) { //read
    $CI =& get_instance();
    $CI ->db->where('id_factura',$id);
    $rs = $CI->db->get($tabla)->result();
    return $rs;
  }
}
?>
