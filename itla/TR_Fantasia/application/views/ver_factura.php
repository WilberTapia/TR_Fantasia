<?php plantilla::aplicar(); ?>
<div class="container">
  <br>
<br>
<div class="row">
  <div class="col-sm-7">
    <div class="card">
      <div class="card-body">
        <h3>Listado de Facturas</h3>
        <?php
        $urlEditar = base_url('main/factura/');
        echo <<<P
        <a href="{$urlEditar}" class="btn btn-warning float-right">Agregar Factura</a>
P;
         ?>
        <br>
        <br>
      <table class="table table-dark container">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Ver Factura</th>
            </tr>
        </thead>
      <tbody>
        <?php
        $rs = core_crud::listado('factura');
        foreach ($rs as $factura) {
          $urlEditar = base_url('main/imprimirF/'.$factura->id_factura);
          echo <<<factura
        <tr>
        <td>{$factura->id_factura}</td>
        <td>{$factura->fecha}</td>
        <td>
        <a href="{$urlEditar}" class="btn btn-warning">
        <i class="fa fa-check" aria-hidden="true"></i></a>
        </td>
        </tr>
factura;
}?>
      </tbody>
      </table>
    </div>
  </div>
</div>
</div>
</div>
