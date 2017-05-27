<style>
.editableOperador span{
display:block;
}
.editableOperador span:hover{
background:url("http://localhost/slc/public/img/editar.png") 90% 50% no-repeat;
cursor:pointer;
}
.guardarEditableOperador{
background:url("http://localhost/slc/public/img/guardar.png") 0 0 no-repeat;
}
a.enlace{

  display:inline-block;
  width:24px;
  height:24px;
  margin:0 0 0 5px;
  overflow:hidden;
  text-indent:-999em;
  vertical-align:middle;
}
.cancelarEditableOperador{
background:url("http://localhost/slc/public/img/cancelar.png") 0 0 no-repeat;
}
td input{
height:24px;
width:140px;
border:1px solid #ddd;
padding:0 5px;
margin:0;
border-radius:6px;
vertical-align:middle;
}
#formBuscarOperador
{
  width: 40%;
  min-width:40%;
  padding: 3px;
}
#errorFormBuscarOperador
{
  display:none;
}
</style>
<script>
  $(document).on('keyup','#formBuscarOperador',function(e){
    e.preventDefault();
    $.ajax({
      'type':$(this).attr('method'),
      'url':$(this).attr('action'),
      'data':$(this).serialize(),
      success: function(respuesta){
        json = JSON.parse(respuesta);
        $("#errorFormBuscarOperador").css('display','none').html('');
        if(json.respuesta=='exito')
        {
          $('#tablaOperador tbody').empty();
          for(i=0;i<json.operador.length;i++)
          {
            if(json.operador[i].estado==1)
            {
              estado="<button type='button' class='btn btn-success' id='activador_operador' title='desactivar'>Activo</button>";
            }
            else
            {
              estado="<button type='button' class='btn btn-default'  id='activador_operador' title='activar' >Inactivo</button>";
            }
            $('#tablaOperador #tbodyOperador').append("<tr><td class='hide url'>http://localhost/slc/administrador/Administrador/editar_dato_operador</td>"
            +"<td class='hide id'>"+json.operador[i].idusuario+"</td>"
            +"<td class='editableOperador' data-campo='nombre'><span>"+json.operador[i].nombre+"</span></td>"
            +"<td class='editableOperador' data-campo='apellido'><span>"+json.operador[i].apellido+"</span></td>"
            +"<td class='editableOperador' data-campo='cedula'><span>"+json.operador[i].cedula+"</span></td>"
            +"<td class='editableOperador' data-campo='usuario'><span>"+json.operador[i].usuario+"</span></td>"
            +"<td class='editableOperador' data-campo='clave'><span>"+json.operador[i].clave+"</span></td>"
            +"<td class='text-center'>"+estado+"</td>"+"</tr>");

          }
        }
        else
        {
          if(json.error)
          {
            $("#errorFormBuscarOperador").css('display','block').append(""+json.error+"");
          }
          else
          {
            if(json.error_operador)
            {
              $("#errorFormBuscarOperador").css('display','block').append(""+json.error_operador+"");
            }

          }

        }
      }

    });

  });
</script>
<?php if($cantida_operador>0):?>

    <?php echo form_open(base_url('administrador/Administrador/buscarOperador'),array('class'=>'form-inline ','role'=>'form','id'=>'formBuscarOperador'));?>
      <div class='form-group'>
        <label for='buscarUsuariosUsuario' class='text-primary' >Buscar Usuarios: </label>
        <input type='text' class='form-control' id='buscarOperador' name='buscarOperador' placeholder="Digite Usuario">
      </div>
      <div class="form-group">
        <div class="form-control alert alert-danger" role='alert' id='errorFormBuscarOperador'></div>
      </div>

    <?php echo form_close();?>
    <div class='table table-responsive'>

      <table class='table table-bordered' id='tablaOperador'>
        <caption><h3 class='text-center text-primary'>Reportes de Operadores</h3></caption>
        <thead>
          <tr>
            <th class='hide'>Id</th>
            <th class='text-info text-center'>Nombre</th>
            <th class='text-info text-center'>Apellido</th>
            <th class='text-info text-center'>Cedula</th>
            <th class='text-info text-center'>Usuario</th>
            <th class='text-info text-center'>Clave</th>
            <th class='text-info text-center'>Estado Operador</th>
          </tr>
        </thead>
        <tbody id='tbodyOperador'>
            <?php foreach($operador as $operadores):?>
          <tr>
              <td class='hide url'><?php echo base_url('administrador/Administrador/editar_dato_operador');?></td>
              <td class='hide id'><?php echo $operadores['idusuario'];?></td>
              <td class='editableOperador' data-campo='nombre'><span><?php echo $operadores['nombre'];?></span></td>
              <td class='editableOperador' data-campo='apellido'><span><?php echo $operadores['apellido'];?></span></td>
              <td class='editableOperador' data-campo='cedula'><span><?php echo $operadores['cedula'];?></span></td>
              <td class='editableOperador' data-campo='usuario'><span><?php echo $operadores['usuario'];?></span></td>
              <td class='editableOperador' data-campo='clave'><span><?php echo $operadores['clave'];?></span></td>
              <td class='text-center'>
                <?php if($operadores['estado']==1):?>
                  <button type='button' class='btn btn-success' id='activador_operador' title='desactivar'>Activo</button>
                <?php else :?>
                  <button type='button' class='btn btn-default'  id='activador_operador' title='activar' >Inactivo</button>
                <?php endif;?>
              </td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      <div id='cantida_operador'>Cantidad : <?php echo $cantida_operador;?></div>
    </div>
<?php else :?>
    <h3 class='text-center text-info'>No hay operadores registrado en el sistema</h3>

<?php endif;?>