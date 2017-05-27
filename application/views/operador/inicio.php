<!doctype html>
<html lang='es'>
  <head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href=<?=base_url('favicon.ico');?>>
    <title>Inicio</title>
    <link rel="stylesheet" href=<?=base_url('public/bootstrap/css/bootstrap.min.css');?>>
    <link rel="stylesheet" href=<?=base_url("public/bootstrap/css/bootstrap-theme.min.css");?>>
    <link rel="stylesheet" href=<?=base_url("public/jqueryui/jquery-ui.min.css");?>>
    <link rel="stylesheet" href=<?=base_url("public/jqueryui/jquery-ui.theme.min.css");?>>

    <style>
      .banner
      {
        background-color: white;
      }
      #section
      {
        width:100%;
        padding: 0px;
        margin: 0px;
      }
      
    </style>
    <script src=<?=base_url("public/jquery/jquery.js");?>></script>
    <script src=<?=base_url("public/bootstrap/js/bootstrap.min.js");?>></script>
    <script src=<?=base_url("public/jqueryui/jquery-ui.min.js");?>></script>
    <script>
      $(document).ready(function(){

        //recarga de la pagina de inicio
        $('#inicio').on('click',function(e){
          e.preventDefault();
          window.location.reload();
        });


        //function que llama al formulario para cambiar clave
        $('#form_cambiar_clave').on('click',function(e){
          e.preventDefault();
          $.ajax({
            type:'post',
            url : $(this).attr('href'),
            beforeSend : function()
            {
              $('#section').html('<img class="img img-responsive center-block" src="http://localhost/slc/public/img/cargando.gif">');
            },
            success : function(respuesta)
            {
              $('#section').html(respuesta);
            }
          });
        });

        //funcion que llama al modal para salir de session
        $("#salirSesion").on('click',function(e){
        e.preventDefault();
        url = $(this).attr('href');
        $("#salirdesesion").modal('show');
        //funcion para comprobar si el usuario desea salir de session
        $("#nosalirsesion, #sisalirsesion").on('click',function(e){
            e.preventDefault();
            valor = $(this).val();
            if(valor=="si")
            {
              $("#salirdesesion").modal('hide');
              window.location=""+url;

            }
            else
            {
              $("#salirdesesion").modal('hide');
            }
        });
      });
     
      $('#manual').on('click',function(e){
        e.preventDefault();
          window.open($(this).attr('href'),'Manual de Usuario','width=1200px,height=auto,resizable=yes,scrollbars=yes,status=yes,location=no');
      });
      });
    </script>
  </head>
  <body style='padding-top: 175px;'>
    <div class="container-fluid master">
   <div class="row" style='padding:0px; margin:0px;'>
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       <header class="navbar navbar-default navbar-fixed-top" role="navigation">
         <img class="img img-responsive center-block" style='max-width: 519px;' src=<?=base_url("public/img/img-alcasa.png");?>>
         <nav>
           <div class="navbar-header">
             <div class="navbar-brand"><p title="Sistema de Licitaciones de Concurso" style="color:#337ab7; font-weght:bold; font-size:1em;">S.L.C</p></div>
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
               <span class="sr-only"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
             </button>

           </div>
           <div class="collapse navbar-collapse" id="menu">
             <ul class="nav nav-pills nav-justified">
               <li>
                 <a href="" class="btn btn-md" title="Inicio" id="inicio" style="font-weight: bold;">Inicio </a>
               </li>
               <li class="dropdown">
                   <a href="" title="Registrar" class="dropdown-toggle btn btn-md" data-toggle="dropdown" style="font-weight: bold;">Registrar <span class="caret"></span> </a>
                   <ul class="dropdown-menu" role="menu" style="box-shadow:0px 0px 12px rgba(0,0,0,0.5);">
                     <li role="presentation" class="dropdown-header">Registrar</li>
                   </ul>
                 </li>
                 <li class="dropdown">
                   <a href="" title="Reportes" class="dropdown-toggle btn btn-md" data-toggle="dropdown" style="font-weight: bold;">Reportes <span class="caret"></span></a>
                   <ul class="dropdown-menu" role="menu" style="box-shadow:0px 0px 12px rgba(0,0,0,0.5);">
                     <li role="presentation" class="dropdown-header">Reportes </li>
                   </ul>
                 </li>
                 <li class="dropdown">
                   <a href="" class="dropdown-toggle btn btn-md" data-toggle="dropdown" title="Configurar" style="font-weight: bold;">Configurar <span class="caret"></span></a>
                   <ul class="dropdown-menu" role="menu" style="box-shadow:0px 0px 12px rgba(0,0,0,0.5);">
                     <li role="presentation" class="dropdown-header">Configurar </li>
                     <li class="divider"></li>
                     <li><a href="<?php echo base_url('operador/Operador/form_cambiar_clave');?>" id="form_cambiar_clave" role="menuitem" tabindex="-1"> Clave de Usuario</a> </li>

                   </ul>
                 </li>
                 <li>
                   <a href="<?php echo base_url('SalirSesion');?>" class="btn btn-md" id="salirSesion" style="font-weight: bold;">Salir (<?php echo $this->session->userdata('usuario');?>)</a>
                 </li>
             </ul>
           </div>
         </nav>
       </header>


       <!--modal de distintos errores -->
       <div class="modal fade" tabindex="-1" role="dialog" id="distintosErrores" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                       <h3 class="modal-title text-center text-info" id='distintosErrores_title'>Error del Sistema</h3>
                 </div>
                 <div class="modal-body text-center" id="distintosErrores_body"></div>
           </div>
         </div>
       </div>
       <!--fin del modal de distintos errores -->
       <!---modal para salir de session-->
       <div class="modal fade" tabindex="-1" role="dialog" id="salirdesesion" aria-labelledby="myModalLabel" aria-hidden='true'>
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <h4 class="modal-title">
                   Salir de Sesion
                 </h4>
               </div>
               <div class="modal-body text-center text-info">
                 Deseas Salir de Sesion <?php echo $this->session->userdata('usuario');?> ?

               </div>
               <div class="modal-footer text-center">
                 <button id="sisalirsesion" type="button" value='si' class="btn btn-primary">
                   <span class="glyphicon glyphicon-ok-sign"> Aceptar</span>
                 </button>
                 <button id="nosalirsesion" type="button" value='no' class="btn btn-danger">
                   <span class="glyphicon glyphicon-remove-sign"> Cancelar</span>
                 </button>
               </div>
             </div>
           </div>
         </div>
         <!---fin modal para salir de session-->
       <section id="section">
       <?php if(empty($fecha[0]['fecha'])):?>
       <?php else :?>
        <h4 class='text-center text-info'>Ultima fecha de Entrada : <?=$fecha[0]['fecha'].' '.$fecha[0]['hora'];?></h4>
        <?php endif?>
       </section>
     </div>

   </div>
 </div>
  </body>
</html>
