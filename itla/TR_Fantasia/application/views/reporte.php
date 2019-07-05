<?php plantilla::aplicar();
if (!isset($_SESSION['nombre'])) {
	redirect('main');
}
?>

<br>

    <div class='row justify-content-center'>
    <h3>Listado de articulos</h3>
    <br>
    <br>
    </div>
        <div class="container">
    <div class='row justify-content-center'>
        <table class='table'>
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
      </table>
    </div>

<br>
