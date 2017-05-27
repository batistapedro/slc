<style>

#form_reportes_buscar_licitaciones
{
    min-width:50%;
    max-width:50%;
}

</style>

<script>
$(document).ready(function(){
  $('#fecha_desde_licitaciones,#fecha_hasta_licitaciones').datepicker({
  dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
  changeYear: true,
  changeMonth:true,
  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
  minDate: new Date(2016, 1 - 1, 1),
  dateFormat:"yy/mm/dd"
});


});
</script>
<?php echo form_open(base_url('administrador/Administrador/buscar_reportes_licitaciones'),array('class'=>'form center-block','role'=>'form','id'=>'form_reportes_buscar_licitaciones'));?>
<caption><h3 class='text-center text-primary'>Reportes de Licitaciones</h3></caption><hr>

<div class='form-group'>
    <label class='text-primary' for=''>Buscar:</label>
    <select name='filtrado_licitaciones' class='form-control' id='select_licitaciones_opcion' required>
        <option value=''>Elije una Opción</option>
        <option value='todos'>Buscar todas</option>
        <option value='areas'>Buscar por areas</option>
    </select>
</div>

<div class='form-group'>
    <label class='text-primary' for=''>Buscar Concurso</label>
    <select class='form-control' name='buscar_estado_licitaciones' id='buscar_estado_licitaciones'>
        <option value='todos'>Todos los Concursos</option>
        <option value='abierto'>Concursos Abiertos</option>
        <option value='cerrado'>Concursos Cerrados</option>
    </select>
</div>

<div class='form-group hide' id='buscar_licitaciones_areas'>
      <label class='text-primary' for=''>Buscar Area:</label>
    <select name='filtrado_licitaciones_areas' class='form-control' id='filtrado_licitaciones_areas'>
        <?php foreach($areas as $area):?>
        <option value='<?=$area["idarea"];?>'><?=$area['nombre_area'];?></option>
        <?php endforeach;?>
    </select>
</div>

<div class='form-group' id='buscar_licitaciones_fechas'>
    
        <div class='col-sm-6 col-md-6 col-lg-6'>
            <div class='form-group'>
                <label class='text-primary' for=''>Fecha Desde :</label>
                <input type='text' class='form-control' id='fecha_desde_licitaciones' name='fecha_desde_licitaciones' required>
            </div>    
        </div>
        <div class='col-sm-6 col-md-6 col-lg-6'>
            <div class='form-group'>
                <label class='text-primary' for=''>Fecha Hasta :</label>
                <input type='text' class='form-control' id='fecha_hasta_licitaciones' name='fecha_hasta_licitaciones' required>
            </div> 
        </div>
    
</div>

<div class='form-group text-center'>
    <button type='submit' class='btn btn-success'> <span class='glyphicon glyphicon-search'></span> Buscar</button>
    <button type='reset' class='btn btn-danger'> <span class='glyphicon glyohicon-remove-sign'></span> Limpiar</button>
</div>

<?php echo form_close();?>
<hr>
<div id='section_licitaciones'></div>