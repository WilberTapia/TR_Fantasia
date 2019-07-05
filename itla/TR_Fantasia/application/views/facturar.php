<?php plantilla::aplicar();
if (!isset($_SESSION['nombre'])) {
	redirect('main');
}

$CI =& get_instance();

$fecha = date('Y-m-d');
$factura = new stdClass;
$factura->id_factura = '';
$factura->id_cliente = '';
$factura->fecha = '';

//$idF = $this->uri->segment(3);

$cliente = new stdClass;
$cliente->id ='';
$cliente->Nombre ='';

if($_POST){
  $factura->id_cliente = $idC;
  $factura->fecha = $fecha;

  core_crud::guardarF('factura',$factura);
  $idF = $CI->db->query("select id_factura from factura order by id_factura desc limit 1;")->result_array();
  //articulos
	$art_nombre = $_POST['art_nombre'];
  $art_id_producto = $_POST['art_id_producto'];
	$art_id_cantidad = $_POST['art_id_cantidad'];
  $art_precio = $_POST['art_precio'];
  $art_cantidad = $_POST['art_cantidad'];
  $art_subtotal = $_POST['art_subtotal'];
  $itbis = $_POST['itbis'];
  $total = $_POST['total'];
	$datos = array();
  $datosA = array();
  foreach ($art_nombre as $k => $nombre) {
    $datos[] = array(
      'id_factura' => $idF[0]['id_factura'],
      'id_producto' => $art_id_producto[$k],
      'cantidad' => $art_cantidad[$k],
      'precio' => $art_precio[$k],
      'subtotal' => $art_subtotal[$k],
      'itbis' =>  $_POST['itbis'],
      'total' => $_POST['total']
    );
  }
  $CI ->db->insert_batch('detalle_factura', $datos);
	foreach ($art_nombre as $k => $nombre) {
		$datosA[] = array(
			'id' => $art_id_producto[$k],
			'Existencia' => $art_id_cantidad[$k],
		);
	}
	$CI ->db->update_batch('articulos', $datosA,'id');



redirect('main/imprimirF/'.$idF[0]['id_factura']);
}else if (isset($idC)) {
  $rs = core_crud::x_id($idC,'clientes');
  if (count($rs) > 0) {
    $cliente = $rs[0];
  }
}
 ?>
<div class="container">
<br>
<br>
<div class="row justify-content-center">
  <h3>Factura </h3>
</div>
<div class="flex-column d-flex float-right" >

    <button onclick="show();" type="button" class="btn btn-primary">Agregar Cliente</button>
  <br>
    <button onclick="nuevaFila();" type="button" class="btn btn-primary">Agregar Articulo</button>
</div>
<form action="" method="post">
    <div class="row">
      <div class="col-sm">
        <div class="card">
          <div class="card-body">
            <?= asgInputF('nombre', 'Nombre', ['placeholder'=>'Digite la Nombre'], $cliente->Nombre)?>
            <?= asgInputF('fecha', 'Fecha', ['placeholder'=>'Digite la Nombre'], $fecha)?>
          </div>
        </div>
      </div>
      </div>
      <br>
      <table class='table'>
          <thead>
              <tr>
                  <th>Cantidad</th>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>SubTotal</th>
                  <th></th>
              </tr>
          </thead>
          <tbody id="tbody">
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>
    <div class="col-sm-5 d-flex flex-row-reverse float-right">
      <div class="card">
        <div class="card-body">
          <?= asgInputF('subtotal', 'Subtotal') ?>
          <?= asgInputF('itbis', 'Itbis') ?>
          <?= asgInputF('total', 'Total') ?>
            <button type="submit"class="btn btn-primary" >
            <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
          <button onclick="return confirm('¿Esta seguro?');" class="btn btn-danger" type="reset" >
            <i class="fa fa-trash" aria-hidden="true"></i> Limpiar</button>
          </div>
        </div>
      </div>
    </div>
    </form>
<br><br><br>
    <dialog id="dialogClientes" style="width:50%;background-color:#F4FFEF;border:1px dotted black;">
      <div class="card">
        <div class="card-body">
          <h4>Agregar Cliente</h4>
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
                $urlEditar = base_url("main/editarF/{$clientes->id}");
                echo <<<CLIENTES
              <tr>
              <td>{$clientes->id}</td>
              <td>{$clientes->Cedula}</td>
              <td>{$clientes->Nombre}</td>
              <td>{$clientes->Correo}</td>
              <td>{$clientes->Telefono}</td>
              <td>
              <a href="{$urlEditar}" class="btn btn-dark">
              <i class="fa fa-check" aria-hidden="true"></i></a></td>

              </tr>
CLIENTES;
    }?>
          </tbody>
        </table>
        </div>
      </div>
      <br>
      <button onclick="hide();" type="button" class="btn btn-primary float-right">Cerrar</button>
    </dialog>

		<?php $rs = $CI->db->get('articulos')->result_array();
		$json = json_encode($rs);
		file_put_contents("datos.json", $json);
		?>

<textarea style="display:none" id="idText">
<form method="post" action="">
	<input type="hidden" value="{id_producto}" class="form-control" name="art_id_producto[]">
		<input type="hidden" value="{art_id_cantidad}" class="form-control" name="art_id_cantidad[]">
  <td>
    <input onkeyup="calcular();" type="text" value="{cantidad}" class="form-control" name="art_cantidad[]" required>
  </td>
  <td>
		 <select required class='custom-select mr-sm-2' name='art_nombre[]'>
		 <option value=''>Seleccionar Articulo</option>
        <?php
				$rs = core_crud::listado('articulos');
				foreach ($rs as $articulos) {
            echo '<option value="'.$articulos->Nombre.'">'.$articulos->Nombre.'</option>';
          }
        ?>
			</select>
  <!--  <input type="text"  class="form-control" name="art_nombre[]" required>-->
  </td>
  <td>
    <input onblur="verificar();" type="text"  onkeyup="calcular();" value="{precio}" class="form-control" name="art_precio[]" required>
  </td>
  <td>
    <input type="text" value="{subtotal}" class="form-control" name="art_subtotal[]" readonly required>
  </td>
</form>
</textarea>

<script type="text/javascript">
var dialog = document.getElementById('dialogClientes');
  function show() {
    dialog.showModal();
  }
  function hide() {
    dialog.close();
  }

  var dialogA = document.getElementById('dialogA');
    function showA() {
      dialogA.showModal();
    }
    function hideA() {
      dialogA.close();
    }

  function nuevaFila() {
    obj = {};
    obj.cantidad ='';
    obj.nombre ='';
    obj.precio ='';
    obj.subtotal='';
    agregarFila(obj);
  }

  function agregarFila(obj) {
    tr = document.createElement('tr');
    cont = document.getElementById('idText').value;
   for (prop in obj) {
      cont = cont.replace('{'+prop+'}', obj[prop]);
    }
    tr.innerHTML = cont;
    document.getElementById('tbody').appendChild(tr);
  }
  function my_num(num) {
    rs = 0;
    tmp = parseFloat(num);
    if (!isNaN(tmp)) {
      rs = tmp;
    }
    return rs;
  }

  function calcular() {
    total = 0;
    itbis = 0;
    precio = document.getElementsByName('art_precio[]');
    cantidad = document.getElementsByName('art_cantidad[]');
    subtotal = document.getElementsByName('art_subtotal[]');

    for (var i = 0; i < precio.length; i++) {
      sub = (my_num(precio[i].value) * my_num(cantidad[i].value)).toFixed(2);
      subtotal[i].value = sub;
      total += my_num(sub);
    }
    document.getElementById('subtotal').value = total;
    itbis = total * 0.18;
    document.getElementById('itbis').value = itbis;
    total += itbis;
    document.getElementById('total').value = total;

  }

	function verificar() {
		precio = document.getElementsByName('art_precio[]');
		nombre = document.getElementsByName('art_nombre[]');
		cantidad = document.getElementsByName('art_cantidad[]');

		const xhttp = new XMLHttpRequest();
		xhttp.open('GET', '/itla/TR_Fantasia/datos.json', true);
		xhttp.send();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let datos = JSON.parse(this.responseText);
				for (let registros of datos) {
					for (var i = 0; i < nombre.length; i++) {
						if (registros.Nombre == nombre[i].value) {
							console.log("Registros " + parseInt(registros.Existencia - cantidad[i].value));
							console.log("Form" + cantidad[i].value);
							if (my_num(registros.Costo) > my_num(precio[i].value) && my_num(registros.Existencia) < my_num(cantidad[i].value) ) {
								alert('El articulo no se puede vender mas barato')
								alert('Ni se puede vender articulos que no hay existencia');
								document.getElementsByName('art_precio[]')[i].value = '0';
								document.getElementsByName('art_cantidad[]')[i].value = '0';
							}else if(my_num(registros.Existencia) < my_num(cantidad[i].value)) {
								alert('No se puede vender articulos que no hay existencia \nLa existencia acutal es: '+ registros.Existencia)
								document.getElementsByName('art_cantidad[]')[i].value = '0';
							}else if (my_num(registros.Costo) > my_num(precio[i].value)) {
								alert('El articulo no se puede vender mas barato \nEl precio minimo es: '+ registros.Costo)
								document.getElementsByName('art_precio[]')[i].value = '0';
							}
							calcular();
							document.getElementsByName('art_id_producto[]')[i].value = registros.id;
							document.getElementsByName('art_id_cantidad[]')[i].value = parseInt(registros.Existencia - cantidad[i].value);
						}
					}
		    }
			}
		}
	}
</script>
