<?php plantilla::aplicar(); ?>
<?php
$base = base_url('base');
if (!isset($_SESSION['nombre'])) {
	redirect('main');
} ?>
<!--<link href="<?= $base; ?>/css/the-big-picture.css" rel="stylesheet">-->
  <!-- Page Content -->
	<br>
	<br>
    <div class="container">
			<div class="row">
			  <div class="col-sm-6">
			    <div class="card">
			      <div class="card-body">
			        <h3>Articulos Disponibles</h3>
			        <br>
			      <table class="table table-dark container">
							<thead>
									<tr>
											<th>ID</th>
											<th>Nombre</th>
											<th>Existencia</th>
									</tr>
							</thead>
							<tbody>
							<?php
							$rs = core_crud::listado('articulos');
							foreach ($rs as $articulos) {
								echo <<<ARTICULOS
							<tr>
							<td>{$articulos->id}</td>
							<td>{$articulos->Nombre}</td>
							<td>{$articulos->Existencia}</td>
							</tr>
ARTICULOS;
	}?>
					</tbody>
			      </tbody>
			      </table>
			    </div>
			  </div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h3>Reporte de Ventas Diarias</h3>
						<br>
					<table class="table table-dark container">
						<thead>
								<tr>
										<th>Fecha</th>
										<th>Total</th>
								</tr>
						</thead>
						<tbody>
						<?php
						$CI =& get_instance();
						$rs = $CI->db->query("SELECT FECHA, SUM(TOTAL) as TOTAL FROM detalle_factura df
																    JOIN factura f ON  f.id_factura=df.id_factura
																		GROUP BY F.fecha;")->result();
						foreach ($rs as $articulos) {
							$total = number_format($articulos->TOTAL,2);
							echo <<<ARTICULOS
						<tr>
						<td>{$articulos->FECHA}</td>
						<td> {$total} </td>
						</tr>
ARTICULOS;
}?>
				</tbody>
					</tbody>
					</table>
				</div>
			</div>
		</div>
			</div>
    </div>
