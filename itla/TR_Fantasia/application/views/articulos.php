<?php plantilla::aplicar();
if (!isset($_SESSION['nombre'])) {
	redirect('main');
}
$CI =& get_instance();
$idF = $CI->db->query("select id from articulos order by id desc limit 1;")->result_array();

if(isset($idF) && $idF > 0){
	$idF = ($idF[0]['id']) + 1;
}else {
	$idF = 1;
}

if($_POST){
  	$articulos = array(
		'id' => $_POST['id'],
		'Nombre' => $_POST['nombre'],
		'Costo' => $_POST['costo'],
		'Precio' =>$_POST['precio'],
		'Existencia' => $_POST['existencia']);
  core_crud::guardar('articulos',$articulos);

	$mysqli=new mysqli("localhost","root","","tr");
	if (mysqli_connect_errno()) {
			die("Error al conectar: ".mysqli_connect_error());
	}

	# Comprovamos que se haya subido un fichero
	if (is_uploaded_file($_FILES["userfile"]["tmp_name"])){
			# verificamos el formato de la imagen
			if ($_FILES["userfile"]["type"]=="image/jpeg" || $_FILES["userfile"]["type"]=="image/pjpeg" || $_FILES["userfile"]["type"]=="image/gif" || $_FILES["userfile"]["type"]=="image/bmp" || $_FILES["userfile"]["type"]=="image/png"){
					# Cogemos la anchura y altura de la imagen
					$info=getimagesize($_FILES["userfile"]["tmp_name"]);
					# Escapa caracteres especiales
					$imagenEscapes=$mysqli->real_escape_string(file_get_contents($_FILES["userfile"]["tmp_name"]));
					# Agregamos la imagen a la base de datos
					$sql="INSERT INTO `imagephp` (anchura,altura,tipo,imagen, id_articulo, id_cliente) VALUES (".$info[0].",".$info[1].",'".$_FILES["userfile"]["type"]."','".$imagenEscapes."', '".$idF."', 0)";
					$mysqli->query($sql);
					# Cogemos el identificador con que se ha guardado
					$id=$mysqli->insert_id;
					# Mostramos la imagen agregada
					echo "<div class='mensaje'>Imagen agregada con el id ".$id."</div>";
			}else{
					echo "<div class='error'>Error: El formato de archivo tiene que ser JPG, GIF, BMP o PNG.</div>";
			}
	}
	redirect('main/articulos');

}

$articulo = new stdClass;
$articulo->id ='';
$articulo->Nombre ='';
$articulo->Costo ='';
$articulo->Precio ='';
$articulo->Existencia ='';

if (isset($id)) {
  $rs = core_crud::x_id($id,'articulos');
  if (count($rs) > 0) {
    $articulo = $rs[0];
  }
}
 ?>

 <div class="container">
	 <div class='row justify-content-center'>
		 <br>
    <h3>Listado de articulos</h3>
    <br>
    </div>
        <table class='table'>
            <thead>
                <tr>
										<th>ID</th>
                    <th>Nombre</th>
                    <th>Costo</th>
                    <th>Precio</th>
                    <th>Existencia</th>
										<th></th>
                </tr>
            </thead>
						<tbody>
            <?php
						$rs = core_crud::listado('articulos');
						foreach ($rs as $articulos) {
							$urlEditar = base_url('main/editar/articulos/'.$articulos->id);
							echo <<<ARTICULOS
            <tr>
						<td>{$articulos->id}</td>
						<td>{$articulos->Nombre}</td>
						<td>{$articulos->Costo}</td>
						<td>{$articulos->Precio}</td>
						<td>{$articulos->Existencia}</td>
						<td>
			      <a href="{$urlEditar}" class="btn btn-warning">
						<i class="fa fa-edit" aria-hidden="true"></i></a>
						<button name="si" onclick='show(this);' id="{$articulos->id}" class="btn btn-primary">
						<i class="fa fa-picture-o" aria-hidden="true"></i>VER</button>

						</td>
            </tr>
ARTICULOS;
}?>
				</tbody>
      </table>
<br>

<div class='row justify-content-center'>
    <h3>Agregar nuevo articulo</h3>
    </div>
<br>
<div class="form-group">
	<form method="POST" enctype="multipart/form-data">
	  <input type="hidden" name="id" value="<?= $articulo->id; ?>">
	      <div class="row">
	        <div class="col-sm-7">
	          <div class="card">
	            <div class="card-body">
	              <?= asgInput('nombre', 'Nombre', ['placeholder'=>'Digite la Nombre'], $articulo->Nombre)?>
	              <?= asgInput('costo', 'Costo', ['placeholder'=>'Digite el Costo'], $articulo->Costo)?>
	              <?= asgInput('precio', 'Precio', ['placeholder'=>'Digite el Precio'], $articulo->Precio)?>
	            </div>
	          </div>
	        </div>
					<div class="col-sm-5">
						<div class="card">
							<div class="card-body">
								<?= asgInput('existencia', 'Existencia', ['placeholder'=>'Digite la Existencia'], $articulo->Existencia) ?>

									<div class="input-group">
										 <div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
										</div>
										<div class="custom-file">
												<input name="userfile" type="file" class="custom-file-input" id="inputGroupFile01"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
										</div>
								</div>
								<br>
								<br>
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
	<script type="text/javascript">
	var dialog = document.getElementById('dialogA');

		function show(btn) {
			let id = btn.id;
      window.location.href = './mostrar?ida=' + id;
		}


	</script>
