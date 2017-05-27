<style>

    #form_registrar_area_solicitante
    {
        width:50%;
    }
</style>

<?php echo form_open(base_url('administrador/Administrador/registrar_area_solicitante'),array('class'=>'form center-block','role'=>'form','id'=>'form_registrar_area_solicitante'));?>
<div class='row'>
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
        <caption><h3 class='text-center text-info'>Registrar Area Solicitante</h3></caption>
        <hr>

        <div class='form-group'>
            <label class='text-primary' for='nombre_area_solicitante'>Registrar Area Solicitante:</label>
            <input type='text' class='form-control' name='nombre_area_solicitante' id='nombre_area_solicitante' style='text-transform: uppercase;'>
        </div>

        <div class='form-group text-center'>
            <button type='submit' class='btn btn-success'><span class='glyphicon glyphicon-ok-sign'></span> Registrar</button>
            <button type='reset' class='btn btn-danger'><span class='glyphicon glyphicon-remove-sign'></span> Cancelar</button>
        </div>
    </div>


</div>

<?php echo form_close();?>