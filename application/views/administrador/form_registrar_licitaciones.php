<style>

#form_registrar_licitaciones
{
width:95%;

}

#error_fecha_recibido,#error_solicitud_pedido,#error_area_solicitante_licitaciones,#error_estado_licitaciones,#error_descripcion_licitaciones,#error_observacion_licitaciones
{
 display:none;
}

</style>

<script>
    $('#fecha_recibido').datepicker({
        dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
        changeYear: true,
        changeMonth:true,
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        minDate: new Date(1940, 1 - 1, 1),
        dateFormat:"yy/mm/dd"
    });

</script>
<?= form_open(base_url('administrador/Administrador/registrar_licitaciones'),array('class'=>'form center-block','role'=>'form','id'=>'form_registrar_licitaciones'));?>
    <div class='row'>
     <caption><h3 class='text-center text-primary'>Registrar Licitaciones</h3></caption><hr><br><br>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
            <div class='row'>
                 <div class='col-sm-3 col-md-3 col-lg-3'>
                        <div class='form-group'>
                            <label class='text-primary' for='fecha_recibido'>Fecha Recibido:</label>
                            <input type='text' class='form-control' name='fecha_recibido' id='fecha_recibido' required>
                            <div role='alert' class='alert alert-danger' id='error_fecha_recibido'></div>
                        </div>
                    </div>

            <div class='col-sm-3 col-md-3 col-lg-3'>
                <div class='form-group'>
                    <label class='text-primary' for='solicitud_pedido'>Solicitud de Pedido:</label>
                    <input type='text' class='form-control' name='solicitud_pedido' id='solicitud_pedido' required>
                    <div class='alert alert-danger' role='alert' id='error_solicitud_pedido'></div>
                </div>
            </div>
        
                <div class='col-sm-3 col-md-3 col-lg-3'>
                    <div class='form-group'>
                        <label class='text-primary' for='area_solicitante_licitaciones'>Area solicitante:</label>
                            <select class='form-control' name='area_solicitante' id='area_solicitante' required>
                                <option value=''>Elije el area solicitante</option>
                                <?php foreach($areas as $area ) :?>
                                    <option value=<?=$area['idarea']?>><?=$area['nombre_area'];?></option>
                                <?php endforeach;?>
                            </select>
                        <div class='alert alert-danger' role='alert' id='error_area_solicitante_licitaciones'></div>
                    </div>
                </div>

                <div class='col-sm-3 col-md-3 col-lg-3'>
                    <div class='form-group'>
                        <label class='text-primary' for='estado_licitaciones'>Estado Licitación:</label>
                        <select class='form-control' name='estado_licitaciones' id='estado_licitaciones' required>
                            <option value=''>Elija Estado</option>
                            <option value='1'>ABIERTO</option>
                            <option value='0'>CERRADO</option>
                        </select>
                        <div class='alert alert-danger' role='alert' id='error_estado_licitaciones'></div>
                    </div>
                </div>                

            </div>
        
        </div>


        <div class'col-sm-12 col-md-12 col-lg-12'>
            <div class='row'>
                
                <div class'col-sm-12 col-md-12 col-lg-12'>
                    <div class='form-group'>
                        <label class='text-primary' for='descripcion_licitaciones'>Descripción:</label>
                        <textarea id='descripcion_licitaciones' class='form-control' name='descripcion_licitaciones'></textarea>
                        <div class='alert alert-danger' id='error_descripcion_licitaciones' role='alert'>
                    </div>
                </div>

                <div class'col-sm-12 col-md-12 col-lg-12'>
                    <div class='form-group'>
                        <label class='text-primary' for='observacion_licitaciones'>Observación:</label>
                        <textarea id='observacion_licitaciones' class='form-control' name='observacion_licitaciones'></textarea>
                        <div class='alert alert-danger' id='error_observacion_licitaciones' role='alert'>
                    </div>
                </div>

            </div>
        </div>
            
       
     

        <div class='form-group text-center'>
                
                    <button type='submit' class='btn btn-success'>Registrar <span class='glyphicon glyphicon-send'></span></button>
                    <button type='reset' class='btn btn-danger'>Limpiar <span class='glyphicon glyphicon-remove-sign'></span></button>
        </div>
    
    </div>


<?= form_close();?>

            

        

        