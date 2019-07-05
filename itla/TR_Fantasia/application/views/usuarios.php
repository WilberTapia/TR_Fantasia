<?php plantilla::aplicar();
if (!isset($_SESSION['nombre'])) {
	redirect('main');
}

if($_POST){
  $usuarios = $_POST;
  core_crud::guardar('usuarios',$usuarios);
  redirect('main/usuarios');
}
 ?>

 <div class="container">
	 <br><br>
    <div class='row justify-content-center'>
    <h3>Listado de usuarios</h3>
    <br>
    </div>
        <table class='table'>
            <thead>
                <tr>
										<th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                </tr>
            </thead>
						<tbody>
            <?php
						$rs = core_crud::listado('usuarios');
						foreach ($rs as $usuarios) {
							echo <<<usuarioS
            <tr>
						<td>{$usuarios->id}</td>
						<td>{$usuarios->nombre}</td>
						<td>{$usuarios->usuarios}</td>

            </tr>
usuarioS;
}?>
				</tbody>
      </table>

<br>

<div class='row justify-content-center'>
    <h3>Agregar nuevo usuario</h3>
    </div>
<br>
<div class="form-group">
	<form method="post" action="">
	  <input type="hidden" name="id">
	      <div class="row">
	        <div class="col-sm-7">
	          <div class="card">
	            <div class="card-body">
	              <?= asgInput('nombre', 'Nombre', ['placeholder'=>'Digite la Nombre'])?>
	              <?= asgInput('usuarios', 'Usuario', ['placeholder'=>'Digite el Usuario'])?>
	              <?= asgInputP('password', 'Contraseña', ['placeholder'=>'Digite la Contraseña'])?>
	            </div>
	          </div>
	        </div>
					<div class="col-sm-5">
						<div class="card">
							<div class="card-body">
									<button type="submit"class="btn btn-primary" >
									<i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
								<button onclick="return confirm('¿Esta seguro?');" class="btn btn-danger" type="reset" >
									<i class="fa fa-trash" aria-hidden="true"></i> Limpiar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
	</form>
</div>
<div style="margin-bottom: 150px;">

</div>
