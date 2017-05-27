<style>
.editableArea span{
display:block;
}
.editableArea span:hover{
background:url("http://localhost/slc/public/img/editar.png") 90% 50% no-repeat;
cursor:pointer;
}
.guardarEditableArea{
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
.cancelarEditableArea{
background:url("http://localhost/slc/public/img/cancelar.png") 0 0 no-repeat;
}

td input{
height:24px;
width:350px;
border:1px solid #ddd;
padding:0 5px;
margin:0;
border-radius:6px;
vertical-align:middle;
text-transform: uppercase;
}

</style>
<div class='table table-responsive'>

<a href=<?php echo base_url('administrador/Administrador/pdf_area_solicitante');?> title='Generar PDF' class='btn btn-success btn-large' id='generar_pdf_area_solicitante'><span class='glyphicon glyphicon-save-file'></span> Generar PDF</a>

    <table class='table table-bordered table-striped'>
        <caption><h3 class='text-center text-primary'>Registro de Areas Solicitantes</h3></caption>
        <thead>
            <tr>
                <th class='hide'>Id</th>
                <th class='text-center text-primary'>Areas Solicitantes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($areas as $area):?>
            <tr>
                <td class='hide url'><?php echo base_url('administrador/Administrador/editar_dato_area_solicitante');?></td>
                <td class='hide idarea'><?= $area['idarea']?></td>
                <td class='editableArea' data-campo='nombre_area'><span><?=$area['nombre_area']?></span></td>
            </tr>
            <?php endforeach;?>
        </tbody>

    </table>
    <div class='text-info text-center'> Cantidad : <span class='badge'><?=$cantida;?></span></div>
</div>