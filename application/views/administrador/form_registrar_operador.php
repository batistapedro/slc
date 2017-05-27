<style>
#error_nombre,#error_apellido,#error_usuario,#error_cedula
{
  display: none;
}
#form_registrar_operador
      {
        width:50%;
      }
</style>
<script>
  $(document).ready(function(){
    var usuario;

    $('#nombre').blur(function(){
      usuario = $('#nombre').val().slice(0,1)+ $('#apellido').val();
      $("#usuario").val(usuario);
    });

    $('#apellido').blur(function(){
      usuario = $('#nombre').val().slice(0,1)+$('#apellido').val();
      $("#usuario").val(usuario);
    });
  });
</script>

<?php echo form_open(base_url('administrador/Administrador/registrar_operador'),array('class'=>'form center-block','role'=>'form','id'=>'form_registrar_operador'));?>
<caption><h3 class='text-center text-info'>Registrar Operador</h3></caption><hr>
<p class='text-danger'>Todo Los Campos Son Obligatorios</p>
<div class='row'>
  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
    <div class="form-group">
      <label for='nombre' class='text-info'>Nombre : </label>
      <input type='text' class='form-control' name='nombre' id='nombre' placeholder='Digite Nombre' required maxlength="15">
      <div class='alert alert-danger' id='error_nombre'></div>
    </div>

    <div class="form-group">
      <label for='apellido' class='text-info'>Apellido : </label>
      <input type='text' class='form-control' name='apellido' id='apellido' placeholder='Digite Apellido' required maxlength="15">
      <div class='alert alert-danger' id='error_apellido'></div>
    </div>

    <div class="form-group">
      <label for='clave' class='text-info'>Cedula : </label>
      <input type='text' class='form-control' name='cedula' id='cedula' placeholder='Digite cedula 19871554' required maxlength="12">
      <div class='alert alert-danger' id='error_cedula'></div>
    </div>

    <div class="form-group">
      <label for='usuario' class='text-info'>Usuario : </label>
      <input type='text' class='form-control' name='usuario' id='usuario' placeholder='Digite Usuario' required maxlength="20">
      <div class='alert alert-danger' id='error_usuario'></div>
    </div>


  </div>
</div>

<div class="form-group text-center">
  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Registrar</button>
  <button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Limpiar</button>
</div>
<?php echo form_close();?>
