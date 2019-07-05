<?php

function asgInput($nombre, $label, $place = [], $valor=''){
  $placeholder ='';
  foreach ($place as $key => $value) {
    $$key = $value;
  }
  return <<<CODIGO
  <div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>{$label}:</b></label>
    <div class="col-sm-8">
      <input type="text" class="form-control" placeholder="{$placeholder}" name='{$nombre}' value='{$valor}' required/>
    </div>
  </div>
CODIGO;
  // code...
}
function asgInputC($nombre, $label, $place = [], $valor=''){
  $placeholder ='';
  foreach ($place as $key => $value) {
    $$key = $value;
  }
  return <<<CODIGO
  <div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>{$label}:</b></label>
    <div class="col-sm-8">
      <input type="email" class="form-control" placeholder="{$placeholder}" name='{$nombre}' value='{$valor}' required/>
    </div>
  </div>
CODIGO;
  // code...
}
function asgInputP($nombre, $label, $place = [], $valor=''){
  $placeholder ='';
  foreach ($place as $key => $value) {
    $$key = $value;
  }
  return <<<CODIGO
  <div class="form-group row">
    <label class="col-sm-4 col-form-label"><b>{$label}:</b></label>
    <div class="col-sm-8">
      <input type="password" class="form-control" placeholder="{$placeholder}" name='{$nombre}' value='{$valor}' required/>
    </div>
  </div>
CODIGO;
  // code...
}


function asgInputF($nombre, $label, $place = [], $valor=''){
  $placeholder ='';
  foreach ($place as $key => $value) {
    $$key = $value;
  }
  return <<<CODIGO
  <div class="input-group input-group-md mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text" id="inputGroup-sizing-sm">{$label}</span>
    </div>
    <input type="text" class="form-control" readonly placeholder="{$placeholder}" id='{$nombre}' name='{$nombre}' value='{$valor}' required aria-label="Small" aria-describedby="inputGroup-sizing-sm">
  </div>
CODIGO;
  // code...
}

?>
