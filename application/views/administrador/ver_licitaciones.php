<style>
.editableLicitaciones span{
display:block;
}
.editableLicitaciones span:hover{
background:url("http://localhost/slc/public/img/editar.png") 90% 50% no-repeat;
cursor:pointer;
}
.guardarEditableLicitaciones{
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
.cancelarEditableLicitaciones{
background:url("http://localhost/slc/public/img/cancelar.png") 0 0 no-repeat;
}

td input{
height:24px;
width:150px;
border:1px solid #ddd;
padding:0 5px;
margin:0;
border-radius:6px;
vertical-align:middle;
text-transform: uppercase;
}


</style>
<div class='table-responsive'>
<?= $boton_pdf;?>
    <table class='table table-bordered'>
        <caption><h3 class='text-center text-info'>Reportes de Licitaciones Por Numero de Solicitud</h3></caption>
        <thead>
            <tr>
                <th class='hide'>id</th>
                <th class='text-primary text-center'>Fecha Recibido</th>
                <th class='text-primary text-center'>Numero de Solicitud</th>
                <th class='text-primary text-center'>Area Solicitante</th>
                <th class='text-primary text-center'>Descripción</th>
                <th class='text-primary text-center'>Observación</th>
                <th class='text-primary text-center'>Estado</th>
                <th class='text-primary text-center'>Fecha Terminado</th>
                <th class='text-primary text-center'>Duracion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($solicitud as $solicitu):?>
            <tr>
                <td class='hide url'><?=base_url('administrador/Administrador/editar_datos_licitaciones');?></td>
                <td class='hide id'><?=$solicitu['idlicitaciones']?></td>
                <td class='text-center editableLicitaciones' data-campo='fecha_recibido'><span><?=$solicitu['fecha_recibido']?></span></td>
                <td class='text-center editableLicitaciones' data-campo='solicitud_pedido'><span><?=$solicitu['solicitud_pedido']?></span></td>
                <td class='text-center'><?=$solicitu['nombre_area']?></td>
                <td class='editableLicitaciones' data-campo='descripcion'><span><?=$solicitu['descripcion']?></span></td>
                <td class='editableLicitaciones' data-campo='observacion'><span><?=$solicitu['observacion']?></span></td>
                <?php if($solicitu['estado']=='1'):?>
                    <td class='text-center'><button class='btn btn-success' title='Cambiar' id='cambiar_estado_licitaciones'>Abierto</button></td>
                <?php else :?>
                    <td class='text-center'><button class='btn btn-danger' title='Cambiar' id='cambiar_estado_licitaciones'>Cerrado</button></td>
                <?php endif;?>
                <td class='text-center'><?=$solicitu['fecha_terminado']?></td>
                <td class='text-center'><?=$solicitu['duracion']?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>