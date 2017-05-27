<style>
   #busc_sol_llicitaciones
   {
       width:50%;
   }
</style>

<script>
    $("#solicitud").autocomplete({
      source: function( request, response ) {
        $.ajax({
          type:'post',
          url:"administrador/Administrador/buscar_solicitud_licitaciones_solicitud",
          data: {
            solicitud:request.term
          },
          dataType:'json',
          success: function(data) {
           response(data);
      },
      minLength: 2,
      select: function( event, ui ) {
      }
      });
      }
    });

    $(document).on('submit','#busc_sol_llicitaciones',function(e){
        e.preventDefault();
        $.ajax({
            type:$(this).attr('method'),
            url:$(this).attr('action'),
            data:$(this).serialize(),
            beforeSend : function(){
                $('#section_solicitud').html('<img class="center-block img img-responsive" src="http://localhost/slc/public/img/cargando.gif">');
            },
            success:function(respuesta)
            {
                $('#section_solicitud').html(respuesta);
            }
        });
    })
 
</script>

<?=form_open(base_url('administrador/Administrador/bus_sol_licitaciones'),array('class'=>'form center-block','role'=>'form','id'=>'busc_sol_llicitaciones'));?>
    <caption><h3 class='text-center text-info'>Formulario de Busqueda de Solicitudes</h3></caption><hr/>
    <div class='form-group'>
        <label class='text-primary' for=''>Numero de Licitaciones :</label>
        <input type='number' class='form-control' name='solicitud' id='solicitud' placeholder='digite el numero de licitacion'>
    </div>

    <div class='form-group text-center'>
        <button type='submit' class='btn btn-success'><span class='glyphicon glyphicon-search'></span> Buscar</button>
        <button type='reset' class='btn btn-danger'><span class='glyphicon glyphicon-remove-sign'></span> Limpiar</button>
    </div>

<?=form_close();?>
<hr/>
<div id='section_solicitud'></div>