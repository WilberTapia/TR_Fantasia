<?php

$id = $this->uri->segment(3);
$CI =& get_instance();

$CI ->db->where('id_factura',$id);
$factura = $CI->db->get('factura')->result_array();

$CI ->db->where('id',$factura[0]['id_cliente']);
$cliente = $CI->db->get('clientes')->result_array();

$CI ->db->where('id_factura',$id);
$det = $CI->db->get('detalle_factura')->result_array();
$subtotal = 0;
  for ($i=0; $i < sizeof($det); $i++) {
    $subtotal += $det[$i]["subtotal"];
  }


 ?>

<body class="container" onload="window.print()" ><!--onload="window.print()"-->
<br>
<br>
<pre >




                                                              TR FANTASIA
                                                  AV. 27 DE FEBRERO ESQ. JOSE TAPIA BREA
                           TELEFONO: (809) 527-2020     	FAX: (809) 686-6652	    	RNC:130-26357-5
--------------------------------------------------------------------------------------------------------------------------------------------
                                                            FACTURA CLIENTE
CEDULA: <?php echo $cliente[0]['Cedula'];?>


NOMBRE: <?php echo $cliente[0]['Nombre']; ?>


RNC: XXXXXXXXXXX

--------------------------------------------------------------------------------------------------------------------------------------------

CANT	            DESCRIPCION	                                                                                       VALOR	    SUBTOTAL
 <?php for ($i=0; $i < sizeof($det); $i++) {
          $CI ->db->where('id',$det[$i]['id_producto']);
          $art = $CI->db->get('articulos')->result_array();
echo "\n ".$det[$i]['cantidad']."                  ".$art[0]['Nombre']."                                                                                            ".number_format($det[$i]["precio"],2)."       ".number_format($det[$i]["subtotal"],2)."\n ";
        }?>


















































--------------------------------------------------------------------------------------------------------------------------------------------

                                                                                                                  SUBTOTAL  <?php echo number_format($subtotal,2); ?>

                                                                                                                  DESC		0.0
                                                                                                                  ITBIS    <?php echo number_format($det[0]["itbis"],2); ?>

                                                                                                                  TOTAL    <?php echo number_format($det[0]["total"],2); ?>

--------------------------------------------------------------------------------------------------------------------------------------------
</pre>
<br>
</body>
