<?php plantilla::aplicar();

$mysqli=new mysqli("localhost","root","","tr");
if (mysqli_connect_errno()) {
    die("Error al conectar: ".mysqli_connect_error());
}
if (isset($_GET["ida"])) {
  $result=$mysqli->query("SELECT * FROM `imagephp` WHERE id_articulo=".$_GET["ida"]);
}else {
  $result=$mysqli->query("SELECT * FROM `imagephp` WHERE id_cliente=".$_GET["idc"]);
}
$row=$result->fetch_array(MYSQLI_ASSOC);

?>
<div class="container">
  <br>
<br>
<div class="row">
  <div class="col-sm-7">
    <div class="card">
      <div class="card-body">
      <table class="table table-dark container">
      <tbody>
        <?php
        if (isset($_GET["ida"])) {
          $rs = core_crud::x_id($_GET["ida"],'articulos');
        }else {
          $rs = core_crud::x_id($_GET["idc"],'clientes');
        }
          foreach ($rs as $articulos) {
            foreach ($articulos as $prop => $value) {
              echo <<<ARTICULOS
                    <tr>
                    <th scope="row">$prop</th>
                    <td>{$articulos->$prop}</td>
                    </tr>
ARTICULOS;
            }
          }
         ?>
      </tbody>
      </table>
    </div>
  </div>
</div>


<?php   echo '<br /><div class="col-sm-5 d-flex flex-row-reverse float-right">
        <div class="card">
          <div class="card-body">
            <img class="img-fluid " src="data:image/jpeg;base64,'.base64_encode( $row["imagen"] ).'"/>
            </div>
          </div>
        </div> ';
 ?>

</div>
