$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });    


    $('#updateModal button.btn-primary').click(function (e) { 
        
        $('.alert').remove();
        $('#btn-actualizar').after($('<div>').addClass('alert alert-danger')
                                             .attr('role', 'alert')
                                             .text('Se estan descargando ficheros desde el repositorio, no cierre ni recargue la página hasta que termine el proceso'));
        $('.alert').append($('<div>').html('Actualizados <b>0</b> ficheros de ' + $('#listado ul li').length));
        
        $('#btn-actualizar').remove();

        $('#listado ul li').each(function (index) {

            let status = $('#listado ul li:eq('+index+') label').text();
            $('#listado ul li:eq('+index+') span').addClass('procesing')
                                                  .html('<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>');
            $.ajax({
                type: "POST",
                url: document.location.href,
                data: {path: $('#listado ul li:eq('+index+') label').text(), status: status},
                success: function (response) {                    
                    $('#listado ul li:eq('+index+') span').addClass('done').text('actualizado'); 
                    $('.alert b').text($('#listado ul li span.done').length);

                    if($('#listado ul li span.done').length == $('#listado ul li').length){
                     
                        $.ajax({
                            type: "POST",
                            url: document.location.href + '/end',                            
                            success: function (response) {                    
                               document.location.reload();
                            }
                        });

                    }
                }
            });  
        });
      
    });
});
