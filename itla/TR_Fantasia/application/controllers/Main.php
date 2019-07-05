<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller{

  public function index(){
    $this -> load -> view("login");
  }

  public function home(){
    $this -> load -> view("index");
  }

  public function cerrar(){
    $this -> load -> view("cierre");
  }

  public function login(){
    $this -> load -> view("comprueba_login");
  }

  public function articulos(){
    $this -> load -> view("articulos");
  }

  public function clientes(){
    $this -> load -> view("clientes");
  }

  public function usuarios(){
    $this -> load -> view("usuarios");
  }

  public function reportes(){
    $this -> load -> view("reporte");
  }

  public function factura(){
    $this -> load -> view("facturar");
  }

  public function verFactura(){
    $this -> load -> view("ver_factura");
  }

  public function editar($tabla, $id=0){
    $tabla = $this->uri->segment(3);
    $id = $this->uri->segment(4);
    $this -> load -> view($tabla,['id'=>$id]);
  }

  public function mostrar(){
    $this -> load -> view('mostrar');
  }

  public function editarF($id = 0){
    $this -> load -> view('facturar',['idC'=>$id]);
  }

  public function imprimirF($id = 0){
    $this -> load -> view('imprimir_factura',['id'=>$id]);
  }
}
?>
