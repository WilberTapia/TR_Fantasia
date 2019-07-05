<?php plantilla::aplicar();
if (!isset($_SESSION['nombre'])) {
	redirect('main');
}

$CI =& get_instance();
$idF = $CI->db->query("select id from clientes order by id desc limit 1;")->result_array();

if(isset($idF) && $idF > 0){
	$idF = ($idF[0]['id']) + 1;
}else {
	$idF = 1;
}

if($_POST){
		$clientes = array(
			'id' => $_POST['id'],
	'Cedula' => $_POST['cedula'],
	'Nombre' => $_POST['nombre'],
	'Correo' =>$_POST['correo'],
	'Telefono' => $_POST['telefono']);
  core_crud::guardar('clientes',$clientes);

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
					$sql="INSERT INTO `imagephp` (anchura,altura,tipo,imagen,id_cliente, id_articulo) VALUES (".$info[0].",".$info[1].",'".$_FILES["userfile"]["type"]."','".$imagenEscapes."', '".$idF."', 0)";
					$mysqli->query($sql);
					# Cogemos el identificador con que se ha guardado
					$id=$mysqli->insert_id;
					# Mostramos la imagen agregada
					echo "<div class='mensaje'>Imagen agregada con el id ".$id."</div>";
			}else{
					echo "<div class='error'>Error: El formato de archivo tiene que ser JPG, GIF, BMP o PNG.</div>";
			}
	}
  redirect('main/clientes');
}

$cliente = new stdClass;
$cliente->id ='';
$cliente->Cedula ='';
$cliente->Nombre ='';
$cliente->Correo ='';
$cliente->Telefono ='';

if (isset($id)) {
  $rs = core_crud::x_id($id,'clientes');
  if (count($rs) > 0) {
    $cliente = $rs[0];
  }
}
 ?>

 <div class="container">
    <div class='row justify-content-center'>
    <h3>Listado de clientes</h3>
    <br>
    <br>
    </div>
    <div class='row justify-content-center'>
        <table class='table'>
            <thead>
                <tr>
										<th>ID</th>
                    <th>Cedula</th>
										<th>Nombre</th>
                    <th>Correo</th>
                    <th>Telefono</th>
										<th></th>
                </tr>
            </thead>
						<tbody>
            <?php
						$rs = core_crud::listado('clientes');
						foreach ($rs as $clientes) {
							$urlEditar = base_url('main/editar/clientes/'. $clientes->id);
							echo <<<CLIENTES
            <tr>
						<td>{$clientes->id}</td>
						<td>{$clientes->Cedula}</td>
						<td>{$clientes->Nombre}</td>
						<td>{$clientes->Correo}</td>
						<td>{$clientes->Telefono}</td>
						<td>
			      <a href="{$urlEditar}" class="btn btn-warning">
						<i class="fa fa-edit" aria-hidden="true"></i></a>
						<button name="si" onclick='show(this);' id="{$clientes->id}" class="btn btn-primary">
						<i class="fa fa-edit" aria-hidden="true"></i>VER</button></td>
            </tr>
CLIENTES;
}?>
				</tbody>
      </table>
    </div>

<br>

<div class='row justify-content-center'>
    <h3>Agregar nuevo cliente</h3>
    </div>
<br>
<div class="form-group">
	<form method="post" action="" enctype="multipart/form-data">
	  <input type="hidden" name="id" value="<?= $cliente->id; ?>">
	      <div class="row">
	        <div class="col-sm-7">
	          <div class="card">
	            <div class="card-body">
	              <?= asgInput('cedula', 'Cedula', ['placeholder'=>'Digite la Cedula'], $cliente->Cedula)?>
								<?= asgInput('nombre', 'Nombre', ['placeholder'=>'Digite la Nombre'], $cliente->Nombre)?>
	              <?= asgInputC('correo', 'Correo', ['placeholder'=>'Digite el Correo'], $cliente->Correo)?>
	            </div>
	          </div>
	        </div>
					<div class="col-sm-5">
						<div class="card">
							<div class="card-body">
								<?= asgInput('telefono', 'Telefono', ['placeholder'=>'Digite el Telefono'], $cliente->Telefono) ?>
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
	<script type="text/javascript">
		function show(btn) {
			let id = btn.id;
      window.location.href = './mostrar?idc=' + id;
		}
	</script>
