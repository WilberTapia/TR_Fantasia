<?php plantilla::aplicar(); ?>

<br>
<h3 class="container">Listado de Personas Agregadas</h3>

<table class ='table container'>
  <thead>
    <tr>
      <th>ID</th>
      <th>ID Vehiculos</th>
      <th>Cedula</th>
      <th>Nombre</th>
      <th>Fecha</th>
      <th>Total</th>

    </tr>
  </thead>
  <tbody>
    <?php
    $rs = core_dealer::listado('ventas');
    foreach ($rs as $ventas) {

    //  $fecha = date('d/m/Y G:i', $ventas->fecha);
    //  $total = ($ventas->precio + ($ventas->precio*0.28));
   // $total = number_format($total, 2);
    /*  $urlBorrar = base_url("main/borrar/{$persona->id}");
      $urlEditar = base_url("main/editar/{$persona->id}");
      $persona->fecha = date('d/m/Y G:i', $persona->fecha);*/
      echo <<<PERSONA
    <tr>
    <td>{$ventas->id}</td>
    <td>{$ventas->idVehiculos}</td>
    <td>{$ventas->cedula}</td>
    <td>{$ventas->nombre}</td>
    <td>{$ventas->fecha}</td>
    <td>{$ventas->total}</td>

      <td>

      </td>
    </tr>
PERSONA;
  }?>
  </tbody>
</table>
