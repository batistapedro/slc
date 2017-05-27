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
      .ui-datepicker-month, .ui-datepicker-year
      {
        background-color: dimgrey;
      }

      
    </style>
    <script src=<?=base_url("public/jquery/jquery.js");?>></script>
    <script src=<?=base_url("public/bootstrap/js/bootstrap.min.js");?>></script>
    <script src=<?=base_url("public/jqueryui/jquery-ui.min.js");?>></script>
    <script>
      $(document).ready(function(){

      //variable globales necesario valor y td para editar campo en las vistas
      var valor=null;
      var td=null;
      var id=null;
      var nuevovalor=null;

      //fin de variables globales

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

        ////////////inicio del codigo del modulo del los operadores/////////////////////////
      
      //funcion que llama al formulario para registrar operador
      $('#registrar_operador').on('click',function(e){
        e.preventDefault();
        $.ajax({
          type:'post',
          url:$(this).attr('href'),
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

      //funcion que envia los datos del formulario registrar operador
      $(document).on('submit','#form_registrar_operador',function(e){
        e.preventDefault();
        $.ajax({
          type :$(this).attr('method'),
          url :$(this).attr('action'),
          data : $(this).serialize(),
          success : function(respuesta)
          {
            $('#error_nombre,#error_apellido,#error_usuario,#error_cedula').css('display','none').html('');
            json = JSON.parse(respuesta);

            if(json.respuesta=='error')
            {

              if(json.error_nombre)
              {
                $("#error_nombre").css('display','block').append(json.error_nombre);
              }

              if(json.error_apellido)
              {
                $("#error_apellido").css('display','block').append(json.error_apellido);
              }

              if(json.error_usuario)
              {
                $("#error_usuario").css('display','block').append(json.error_usuario);
              }

              if(json.error_cedula)
              {
                $("#error_cedula").css('display','block').append(json.error_cedula);
              }

              if(json.error_db)
              {
                $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Error</h3>');
                $('#distintosErrores_body').html('<h4 class="text-danger">'+json.error_db+'</h4>');
                $('#distintosErrores').modal('show');
              }

            }
            else
            {
              $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Exito</h3>');
              $('#distintosErrores_body').html('<h4 class="text-success">'+json.exito+'</h4>');
              $('#distintosErrores').modal('show');
              $('#error_nombre,#error_apellido,#error_usuario,#error_clave').css('display','none').html('');
              $('#nombre,#apellido,#cedula,#usuario,#clave,#gerencias_departamentos,#coordinacion,#cargo,#correo,#tipo_usuario').val('');
            }
          }
        });
      });




      // funcion que muestar el reportes de operador
      $('#reportes_operador').on('click',function(e){
        e.preventDefault();
        $.ajax({
          type:'post',
          url:$(this).attr('href'),
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
    

      //funcion editar operadores
        $(document).on("click","td.editableOperador span",function(e)
        {
          e.preventDefault();
             campo=$(this).closest("td").data("campo");
             
               id=$(this).closest("tr").find(".id").text();
               $("td:not(.id)").removeClass("editableOperador");
                td=$(this).closest("td");
                valor =$(this).text();
               td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'><a class='enlace guardarEditableOperador' href='#' title='Guardar'>Guardar</a> <a class='enlace cancelarEditableOperador' href='#' title='cancelar'>Cancelar</a>");
             

          });
          

      //funcion cancelar editar operadores
     $(document).on("click",".cancelarEditableOperador",function(e)
     {
           e.preventDefault();
           td.text("").html("<span>"+valor+"</span>");
           $("td:not(.id)").addClass("editableOperador");
      });

     //funcion guardar datos editados de operadores
    $(document).on("click",".guardarEditableOperador",function(e)
    {
       e.preventDefault();
        nuevovalor= $(this).closest("td").find("input").val();
        id = $(this).closest("tr").find(".id").text();
        urls = $(this).closest('tr').find('.url').text();
        campo= $(this).closest("td").data("campo");
        td= $(this).closest("td");

         if(nuevovalor.trim()!="")
         {
           $.ajax({
                 type: "post",
                 url: urls,
                 data: { campo: campo, nuevovalor: nuevovalor, id : id },
                 success: function(respuesta)
                 {
                    json  = JSON.parse(respuesta);

                   if(json.respuesta=="error")
                   {
                     $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Error</h3>');
                     $('#distintosErrores_body').html('<h4 class="text-danger">'+json.error+'</h4>');
                     $('#distintosErrores').modal('show');
                     td.text("").html("<span>"+valor+"</span>");
                     $("td:not(.id)").addClass("editableOperador");
                   }
                   else
                   {
                     $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Exito</h3>');
                     $('#distintosErrores_body').html('<h4 class="text-success">'+json.exito+'</h4>');
                     $('#distintosErrores').modal('show');
                     td.text("").html("<span>"+nuevovalor+"</span>");
                     $("td:not(.id)").addClass("editableOperador");
                   }


                 }

               });

         }



     });
      //funcion para activa o desactivar operadores
      $(document).on('click','#activador_operador',function(e){
        e.preventDefault();
        id = $(this).closest('tr').find('.id').text();
        url= $(this).closest('tr').find('.url').text();
        campo = 'estado';
        texto = $(this).text();
        btn = $(this);
        if(texto=='Activo')
        {
          estado=0;
        }
        else
        {
          estado=1;
        }
        $.ajax({
          type:'post',
          url:url,
          data:{id:id,nuevovalor:estado,campo:campo},
          success : function(respuesta)
          {
            console.log(respuesta);
            json  = JSON.parse(respuesta);

           if(json.respuesta=="error")
           {
             $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Error</h3>');
             $('#distintosErrores_body').html('<h4 class="text-danger">'+json.error+'</h4>');
             $('#distintosErrores').modal('show');
           }
           else
           {
             $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Exito</h3>');
             $('#distintosErrores_body').html('<h4 class="text-success">'+json.exito+'</h4>');
             $('#distintosErrores').modal('show');
             if(texto=='Activo')
             {
               btn.removeClass('btn btn-success');
               btn.addClass('btn btn-default');
               btn.attr('title','Inactivo');
               btn.text('Inactivo');
             }
             else
             {
               btn.removeClass('btn btn-default');
               btn.addClass('btn btn-success');
               btn.attr('title','Activo');
               btn.text('Activo');
             }
           }

          }
        });
      });

      /////////////////////// fin de operadores ////////////////////////////////////
    
      /*
      //funcion que gernera el pdf como ventana emergente
      $(document).on('click','.btn_generar_pdf_todos',function(e){
        e.preventDefault();
        window.open($(this).attr('href'),'Reportes de solicitudes','width=1200,height=1100,resizable=yes,scrollbars=yes,status=yes,location=no');
      });

      //funcion que gernera el pdf como ventana emergente
      $(document).on('click','.btn_generar_pdf_departamento',function(e){
        e.preventDefault();
        window.open($(this).attr('href'),'Reportes de solicitudes','width=1200,height=1100,resizable=yes,scrollbars=yes,status=yes,location=no');
      });
      //funcion que llama al formulario de busqueda de encuesta
      $('#reportes_encuesta_usuarios').on('click',function(e){
        e.preventDefault();
        $.ajax({
          type:'post',
          url:$(this).attr('href'),
          beforeSend : function()
          {
          $('#section').html('<img class="center-block img img-responsive" src="http://localhost/slc/public/img/cargando.gif">');
          },
          success : function(respuesta)
          {
            $('#section').html(respuesta);
          }
        });
      });
*/

      ///////////////////// area solicitante ////////////////////////////////////////////
        //funcion que llama al formulario  para registrar las areas solicitantes 
        $("#registrar_area_solicitante").on('click',function(e){
          e.preventDefault();
          $.ajax({
            type:'post',
            url:$(this).attr('href'),
            beforeSend: function()
            {
               $('#section').html('<img class="center-block img img-responsive" src="http://localhost/slc/public/img/cargando.gif">');
            },
            success : function(respuesta)
            {
              $("#section").html(respuesta);
            }
          })
        });

        // formulario para registra las areas solicitantes en la base de datos
        $(document).on('submit','#form_registrar_area_solicitante',function(e){
          e.preventDefault();

          $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            beforeSend : function (){
               $('#distintosErrores_title').html('<h3 class="text-info">Procesando Licitacion</h3>');
               $("#distintosErrores_body").html('<img src="http://localhost/slc/public/img/cargando.gif" class="img img-responsive center-block">');
               $("#distintosErrores").modal('show');
            },
            success: function(respuesta)
            {
              json = JSON.parse(respuesta);

              if(json.respuesta=='error')
              {
              $('#distintosErrores_title').html('<h3 class="text-info">Mensaje de Error</h3>');
               $("#distintosErrores_body").html('<h3 class="text-danger">'+json.error+'</h3>');
               $("#distintosErrores").modal('show');
              }
              else
              {
              $('#distintosErrores_title').html('<h3 class="text-info">Mensaje de Exito</h3>');
               $("#distintosErrores_body").html('<h3 class="text-success">'+json.exito+'</h3>');
               $("#distintosErrores").modal('show');
               $('#nombre_area_solicitante').val('');
              }

            }
          });
        });


        //funcion que muestra el reportes del area de solicitante

        $('#reportes_area_solicitante').on('click',function(e){
          e.preventDefault();
          $.ajax({
            type:'post',
            url:$(this).attr('href'),
            beforeSend : function ()
            {
               $('#section').html('<img class="img img-responsive center-block" src="http://localhost/slc/public/img/cargando.gif">');
            },
            success: function(respuesta)
            {
              $('#section').html(respuesta);
            }
          });
        });


      
      //funcion editar datos de areas solicitantes
        $(document).on("click","td.editableArea span",function(e)
        {
          e.preventDefault();
             campo=$(this).closest("td").data("campo");
              id=$(this).closest('tr').find('.idareea').text();
           
               $("td:not(.idarea)").removeClass("editableArea");
                td=$(this).closest("td");
                valor =$(this).text();
               td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'><a class='enlace guardarEditableArea' href='#' title='Guardar'>Guardar</a> <a class='enlace cancelarEditableArea' href='#' title='cancelar'>Cancelar</a>");
             

          });
         

      //funcion cancelar editar areas solicitcantes
     $(document).on("click",".cancelarEditableArea",function(e)
     {
           e.preventDefault();
           td.text("").html("<span>"+valor+"</span>");
           $("td:not(.idarea)").addClass("editableArea");
      });

     //funcion guardar datos editados de las areas solicitantes
    $(document).on("click",".guardarEditableArea",function(e)
    {
       e.preventDefault();
        nuevovalor= $(this).closest("td").find("input").val();
        id = $(this).closest("tr").find(".idarea").text();
        urls = $(this).closest('tr').find('.url').text();
        campo= $(this).closest("td").data("campo");
        td= $(this).closest("td");

         if(nuevovalor.trim()!="")
         {
           $.ajax({
                 type: "post",
                 url: urls,
                 data: { campo: campo, nuevovalor: nuevovalor, id : id },
                 success: function(respuesta)
                 {
                    json  = JSON.parse(respuesta);

                   if(json.respuesta=="error")
                   {
                     $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Error</h3>');
                     $('#distintosErrores_body').html('<h4 class="text-danger">'+json.error+'</h4>');
                     $('#distintosErrores').modal('show');
                     td.text("").html("<span>"+valor+"</span>");
                     $("td:not(.idarea)").addClass("editableArea");
                   }
                   else
                   {
                     $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Exito</h3>');
                     $('#distintosErrores_body').html('<h4 class="text-success">'+json.exito+'</h4>');
                     $('#distintosErrores').modal('show');
                     td.text("").html("<span>"+nuevovalor+"</span>");
                     $("td:not(.idarea)").addClass("editableArea");
                   }


                 }

               });

         }



     });

     //funcion que genera el archivo pdf del area solicitante del sistema
     $(document).on('click','#generar_pdf_area_solicitante',function(e){
      e.preventDefault();
       window.open($(this).attr('href'),'Reportes de Areas solicitantes','width=1000,height=500,resizable=yes,scrollbars=yes,status=yes,location=no');
     });


      ///////////////////////// fin area solicitante ////////////////////////////////////


      ///////////////////////// incio licitaciones ///////////////////////////////// 
        //funcion que llama al  formulario para registra las licitaciones
        $("#registrar_licitaciones").on('click',function(e){
          e.preventDefault();
          $.ajax({
            type:'post',
            url:$(this).attr('href'),
          beforeSend : function()
          {
          $('#section').html('<img class="center-block img img-responsive" src="http://localhost/slc/public/img/cargando.gif">');
          },
          success : function(respuesta)
          {
            $('#section').html(respuesta);
          }

          });
          
        });
        //funcion que registra las licitaciones en la base de datos
        $(document).on('submit','#form_registrar_licitaciones',function(e){
          e.preventDefault();
          $('#error_fecha_recibido,#error_solicitud_pedido,#error_area_solicitante_licitaciones,#error_estado_licitaciones,#error_descripcion_licitaciones').css('display','none').html('');
          $.ajax({
            type:$(this).attr('method'),
            url:$(this).attr('action'),
            data:$(this).serialize(),
            beforeSend : function(){
                $('#distintosErrores_title').html('<h3 class="text-info">Procesando Licitacion</h3>');
                $("#distintosErrores_body").html('<img src="http://localhost/slc/public/img/cargando.gif" class="img img-responsive center-block">');
                $("#distintosErrores").modal('show');
            },
            success : function(respuesta)
            {
              json = JSON.parse(respuesta);

              if(json.respuesta=='error')
              {
                $("#distintosErrores").modal('hide');

                if(json.error_fecha_recibo)
                {
                    $('#error_fecha_recibido').css({'display':'block'}).append(json.error_fecha_recibo);
                }

                if(json.error_solicitud_pedido)
                {
                    $('#error_solicitud_pedido').css({'display':'block'}).append(json.error_solicitud_pedido);
                }

                if(json.error_area_solicitante)
                {
                    $('#error_area_solicitante_licitaciones').css({'display':'block'}).append(json.error_area_solicitante);
                }

                if(json.error_estado_licitaciones)
                {
                  $('#error_estado_licitaciones').css({'display':'block'}).append(json.error_estado_licitaciones)
                }

                if(json.error_descripcion_licitaciones)
                {
                    $('#error_descripcion_licitaciones').css({'display':'block'}).append(json.error_descripcion_licitaciones);

                }

                if(json.error_observacion_licitaciones)
                {
                    $('#error_observacion_licitaciones').css({'display':'block'}).append(json.error_observacion_licitaciones);
                }

              }
              else
              {
                  if(json.respuesta=='exito')
                  {
                      $('#distintosErrores_title').html('<h3 class="text-info">Mensaje de Exito</h3>');
                      $("#distintosErrores_body").html('<h3 class="text-success">'+json.exito+'</h3>');
                      $("#distintosErrores").modal('show');
                      $('#fecha_recibido,#solicitud_pedido,#area_solicitante,#estado_licitaciones,#descripcion_licitaciones,#error_observacion_licitaciones').val('');
                      $('#error_fecha_recibido,#error_solicitud_pedido,#error_area_solicitante_licitaciones,#error_estado_licitaciones,#error_descripcion_licitaciones').css('display','none').html('');
                  }
                  else
                  {
                    $('#distintosErrores_title').html('<h3 class="text-info">Mensaje Error</h3>');
                    $("#distintosErrores_body").html('<h3 class="text-danger">'+json.error+'</h3>');
                    $("#distintosErrores").modal('show');

                  }

              }
            }
          });
        });

        //funciion que borra los errores del formulario 
        $(document).on('reset','#form_registrar_licitaciones',function(){
            $('#error_fecha_recibido,#error_solicitud_pedido,#error_area_solicitante_licitaciones,#error_estado_licitaciones,#error_descripcion_licitaciones').css('display','none').html('');
        });

        //funcion que llama al formulario para filtrar las busquedas de las licitaciones
        $('#form_buscar_licitaciones').on('click',function(e){
          e.preventDefault();
          $.ajax({
            type:'post',
            url:$(this).attr('href'),
            beforeSend : function()
              {
                 $('#section').html('<img class="center-block img img-responsive" src="http://localhost/slc/public/img/cargando.gif">');
              },
              success:function(respuesta)
              {
                $('#section').html(respuesta);
              }
          });
        });

        //funcion que validar el select de tipo busqueda el formulario form_buscar_licitaciones
      $(document).on('change','#select_licitaciones_opcion',function(e){
        if($(this).val()=='areas')
        {
          $('#buscar_licitaciones_areas').removeClass('hide');
        }
        else
        {
            $('#buscar_licitaciones_areas').addClass('hide');
        }

      });

      $(document).on('submit','#form_reportes_buscar_licitaciones',function(e){
        e.preventDefault();
        $.ajax({
          type:$(this).attr('method'),
          url:$(this).attr('action'),
          data: $(this).serialize(),
          beforeSend : function()
          {
           
            $('#section_licitaciones').html('<img class="center-block img img-responsive" src="http://localhost/slc/public/img/cargando.gif">');
          },
          success :function(respuesta)
          {
            $("#section_licitaciones").html(respuesta);
          }
        });
      });

      //funcion para cerrar o abrir licitaciones
      $(document).on('click','#cambiar_estado_licitaciones',function(e){
        e.preventDefault();
        id = $(this).closest('tr').find('.id').text();
        url= $(this).closest('tr').find('.url').text();
        campo = 'estado';
        texto = $(this).text();
        btn = $(this);
        if(texto=='Abierto')
        {
          estado=0;
        }
        else
        {
          estado=1;
        }
        $.ajax({
          type:'post',
          url:url,
          data:{id:id,nuevovalor:estado,campo:campo},
          success : function(respuesta)
          {
            console.log(respuesta);
            json  = JSON.parse(respuesta);

           if(json.respuesta=="error")
           {
             $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Error</h3>');
             $('#distintosErrores_body').html('<h4 class="text-danger">'+json.error+'</h4>');
             $('#distintosErrores').modal('show');
           }
           else
           {
             $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Exito</h3>');
             $('#distintosErrores_body').html('<h4 class="text-success">'+json.exito+'</h4>');
             $('#distintosErrores').modal('show');
             if(texto=='Abierto')
             {
               btn.removeClass('btn btn-success');
               btn.addClass('btn btn-danger');
               btn.attr('title','Cambiar');
               btn.text('Cerrado');
             }
             else
             {
               btn.removeClass('btn btn-danger');
               btn.addClass('btn btn-success');
               btn.attr('title','Cambiar');
               btn.text('Abierto');
             }
           }

          }
        });
      });


      //funcion para editar datos de licitaciones
        $(document).on("click","td.editableLicitaciones span",function(e)
        {
          e.preventDefault();
             campo=$(this).closest("td").data("campo");
              id=$(this).closest('tr').find('.id').text();
              
             if(campo=='observacion' || campo=='descripcion')
             {
               
              td=$(this).closest("td");
              valor =$(this).text();
                if(campo=='observacion')
                {
                  data_campo='Observación';
                }
                else
                {
                  data_campo='Descripción';
                }
              
               $('#modal_editar_observacion_descripcion .modal-title').html('<h3>Editar datos de '+data_campo+'</h3>');
               $('.datos_observacion_descripcion').val(valor);
               $('#modal_editar_observacion_descripcion').modal('show');


               
          //formulario para editar observaciones y descripcion
          $(document).on('submit','#form_editar_datos_licitaciones_observaciones_descripcion',function(e){
            e.preventDefault();
            nuevovalor = $('.datos_observacion_descripcion').val();
            $.ajax({
              type : $(this).attr('method'),
              url : $(this).attr('action'),
              data:{ id:id,campo:campo,nuevovalor:nuevovalor},
              beforeSend: function()
              {
                
              },
              success : function(respuesta)
              { 
               $('#modal_editar_observacion_descripcion').modal('hide');
                json = JSON.parse(respuesta);
                if(json.respuesta=='error')
                {
                  $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Error</h3>');
                  $('#distintosErrores_body').html('<h4 class="text-danger">'+json.error+'</h4>');
                  $('#distintosErrores').modal('show');
                }
                else
                {
                 
                  $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Exito</h3>');
                  $('#distintosErrores_body').html('<h4 class="text-success">'+json.exito+'</h4>');
                  $('#distintosErrores').modal('show');
                  td.text('').html('<span>'+nuevovalor+'</span>');
                }
              }
            });
          
          });


               
             }
             else
             {
               $("td:not(.id)").removeClass("editableLicitaciones");
                td=$(this).closest("td");
                valor =$(this).text();
               td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'><a class='enlace guardarEditableLicitaciones' href='#' title='Guardar'>Guardar</a> <a class='enlace cancelarEditableLicitaciones' href='#' title='cancelar'>Cancelar</a>");
             }

          });


        

      //funcion cancelar editar datos licitaciones
     $(document).on("click",".cancelarEditableLicitaciones",function(e)
     {
           e.preventDefault();
           td.text("").html("<span>"+valor+"</span>");
           $("td:not(.id)").addClass("editableLicitaciones");
      });

     //funcion guardar datos editados de  licitaciones
    $(document).on("click",".guardarEditableLicitaciones",function(e)
    {
       e.preventDefault();
        nuevovalor= $(this).closest("td").find("input").val();
        id = $(this).closest("tr").find(".id").text();
        urls = $(this).closest('tr').find('.url').text();
        campo= $(this).closest("td").data("campo");
        td= $(this).closest("td");

         if(nuevovalor.trim()!="")
         {
           $.ajax({
                 type: "post",
                 url: urls,
                 data: { campo: campo, nuevovalor: nuevovalor, id : id },
                  beforeSend : function(){
                      $('#distintosErrores_title').html('<h3 class="text-info">Procesando Licitacion</h3>');
                      $("#distintosErrores_body").html('<img src="http://localhost/slc/public/img/cargando.gif" class="img img-responsive center-block">');
                      $("#distintosErrores").modal('show');
                  },
                 success: function(respuesta)
                 {
                    json  = JSON.parse(respuesta);

                   if(json.respuesta=="error")
                   {
                     $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Error</h3>');
                     $('#distintosErrores_body').html('<h4 class="text-danger">'+json.error+'</h4>');
                     $('#distintosErrores').modal('show');
                     td.text("").html("<span>"+valor+"</span>");
                     $("td:not(.id)").addClass("editableLicitaciones");
                   }
                   else
                   {
                     $('#distintosErrores_title').html('<h3 class="text-center text-primary">Mensaje de Exito</h3>');
                     $('#distintosErrores_body').html('<h4 class="text-success">'+json.exito+'</h4>');
                     $('#distintosErrores').modal('show');
                     td.text("").html("<span>"+nuevovalor+"</span>");
                     $("td:not(.id)").addClass("editableLicitaciones");
                   }


                 }

               });

         }



     });
     //esta function crea la ventana que muestra las solicitudes
     //funcion que genera el archivo pdf de todas las licitaciones por fecha, por solicitud
     $(document).on('click','#generar_pdf_todas_licitaciones,#generar_pdf_licitaciones_solicitud,#generar_pdf_todas_licitaciones_areas',function(e){
      e.preventDefault();
       window.open($(this).attr('href'),'Reportes de todas las licitaciones','width=1200,height=500,resizable=yes,scrollbars=yes,status=yes,location=no');
     });

     $(document).on('click','#form_busca_solicitud_licitaciones',function(e){
       e.preventDefault();
       $.ajax({
         type:'post',
         url: $(this).attr('href'),
         beforeSend : function(){
            $('#section').html('<img class="center-block img img-responsive" src="http://localhost/slc/public/img/cargando.gif">');
         },
         success: function(respuesta){
           $('#section').html(respuesta);
         }
       });

     });

     

      // /////////////////// fin de licitaciones ////////////////////////////////////////////

      });
    </script>
  </head>
  <body style='padding-top: 175px;'>
    <div class="container-fluid master">
   <div class="row" style='padding:0px; margin:0px;'>
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       <header class="navbar navbar-default navbar-fixed-top" role="navigation">
         <img class="img img-responsive center-block" src=<?=base_url("public/img/banner.png");?>>
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
                     <li class="divider"></li>
                     <li> <a href="<?php echo base_url('administrador/Administrador/form_registrar_operador');?>" id="registrar_operador" role="menuitem" tabindex="-1"> Operador</a></li>
                    <li class='divider'></li>
                    <li> <a href="<?php echo base_url('administrador/Administrador/form_registrar_licitaciones');?>" id="registrar_licitaciones" role="menuitem" tabindex="-1">Licitaciones</a></li>
                    <li class='divider'></li>
                    <li> <a href="<?php echo base_url('administrador/Administrador/form_resgistrar_area_solicitante');?>" id='registrar_area_solicitante' role='menuitem' tabindex='-1'>Area Solicitante</a></li>
                   </ul>
                 </li>
                 <li class="dropdown">
                   <a href="" title="Reportes" class="dropdown-toggle btn btn-md" data-toggle="dropdown" style="font-weight: bold;">Reportes <span class="caret"></span></a>
                   <ul class="dropdown-menu" role="menu" style="box-shadow:0px 0px 12px rgba(0,0,0,0.5);">
                     <li role="presentation" class="dropdown-header">Reportes </li>
                     <li class="divider"></li>
                     <li> <a href="<?php echo base_url('administrador/Administrador/extraer_operador');?>" id="reportes_operador" role="menuitem" tabindex="-1"> Operador</a></li>
                     <li class='divider'></li>
                     <li> <a href="<?php echo base_url('administrador/Administrador/extraer_area_solicitante');?>" id='reportes_area_solicitante' role='menuitem' tabindex='-1'>Area Solicitante</a></li>
                     <li class='divider'></li>
                     <li><a href="<?php echo base_url('administrador/Administrador/form_buscar_licitaciones');?>" id='form_buscar_licitaciones' role='menuitem' tabindex='-1'>Licitaciones</a></li>
                     <li class='divider'></li>
                    <li><a href="<?php echo base_url('administrador/Administrador/form_buscar_solicitud_licitaciones');?>" id='form_busca_solicitud_licitaciones' role='menuitem' tabindex='-1'>Solicitudes</a></li>
                   </ul>
                 </li>
                 <li class="dropdown">
                   <a href="" class="dropdown-toggle btn btn-md" data-toggle="dropdown" title="Configurar" style="font-weight: bold;">Configurar <span class="caret"></span></a>
                   <ul class="dropdown-menu" role="menu" style="box-shadow:0px 0px 12px rgba(0,0,0,0.5);">
                     <li role="presentation" class="dropdown-header">Configurar </li>
                     <li class="divider"></li>
                     <li><a href="<?php echo base_url('administrador/Administrador/form_cambiar_clave');?>" id="form_cambiar_clave" role="menuitem" tabindex="-1"> Clave de Usuario</a> </li>

                   </ul>
                 </li>
                 <li>
                   <a href="<?php echo base_url('administrador/Administrador/respaldar_bd');?>" title="Respaldar Base de Datos" style="font-weight: bold;">Respaldar BD</a>
                 </li>
                 <li>
                   <a href="<?php echo base_url('SalirSesion');?>" class="btn btn-md" id="salirSesion" style="font-weight: bold;">Salir (<?php echo $this->session->userdata('usuario');?>)</a>
                 </li>
             </ul>
           </div>
         </nav>
       </header>


       <!--modal de distintos errores -->
       <div class="modal fade" tabindex="-2" role="dialog" id="distintosErrores" aria-labelledby="myModalLabel" aria-hidden="true">
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

       <!-- form modal de editar los datos de licitaciones en observacion o descripcion -->
       <div class="modal fade" tabindex="-1" role="dialog" id="modal_editar_observacion_descripcion" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                       <h3 class="modal-title text-center text-info"></h3>
                 </div>
                 <div class="modal-body text-center">
                    <?php echo form_open(base_url('administrador/Administrador/editar_datos_licitaciones'),array('class'=>'form','role'=>'form','id'=>'form_editar_datos_licitaciones_observaciones_descripcion'))?>
                    <div class='form-group'>
                        <textarea class='form-control datos_observacion_descripcion'></textarea>
                     </div>
                  
                     <div class='form-group text-left'>
                       <button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-ok-sing'></span>Registrar</button>
                     </div>
                     <?php echo form_close();?>
                   </div>
                 </div>
           </div>
         </div>
       </div>
       <!--fin modal de editar los datos de licitaciones en observacion o descripcion -->


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
