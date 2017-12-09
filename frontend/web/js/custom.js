$(function(){
    $('#modal_geral').ready(function(){

        jQuery.fn.exists = function(){ return this.length > 0; };

        if($('#cliente-form').exists()) {
            $('.close').remove();
            $('#modal_geral').modal('show');
        }

        else {
            $('.view_model').click(function () {
                var detalhesUrl = $(this).data("detail");

                $('.modal_detalhes').empty();

                $.ajax(detalhesUrl, {
                    method: 'GET',
                    type: 'json',
                }).then(function(data){
                    //$('#modal_detalhes_titulo').text(data[0].titulo);
                    var content = "<h3>Título: "+data[0].titulo+"<small>  Criado a: "+data[0].data_criacao+"</small></h3>";

                    content += "<br>";
                    content += "<h4><b>Troco</b> "+data[1].nome+"</h4>";

                    $.each(data[2], function(i, value){

                        $.each(value, function(i, field){
                            content += "<p>"+i+": " +field+"</p>";
                        });
                        
                    });

                    //-------------------------------------------------
                    content += "<br>";
                    content += "<h4><b>Por</b> "+data[3].nome+"</h4>";

                    $.each(data[4], function(i, value){
                        
                        $.each(value, function(i, field){
                            content += "<p>"+i+": " +field+"</p>";
                        });
                        
                    });

                    content += "<br>";
                    content += "<p>Comentários: </p><p>"+data[0].comentarios+"</p>";

                    $('.modal_detalhes').append(content);

                    $('#modal_geral').modal('toggle');
                });

                
            });
        }
    });

    //##########################################
    //Pesquisa
    //##########################################

    var rowModel = null;

    $('#pesquisa_titulo').on('input',function(){

        if (rowModel == null)
            rowModel = $('.pesquisa-row:first').clone();
        
        $('.anuncio-search').empty();
        $('.pesquisa_loading').css('display', 'block');

        $.ajax($('.pesquisa-control').data("info"), 
        {
            method: 'GET',
            type: 'json',
            data: 
                {
                    "titulo" : $("#pesquisa_titulo").val(), 
                    "categoria" : $("#pesquisa_categoria :selected").val(),
                    "regiao" : $("#pesquisa_regiao :selected").text(),
                },
        }).then(function(anuncios)
        {
            $.each(anuncios, function(i, anuncio) 
            {
                var row = rowModel.clone();

                $('#pesquisa_row_titulo', row).text(anuncio.titulo);
                
                $('.anuncio-search').append(row);

                $('.pesquisa_loading').css('display', 'none');
            });
        });
    });

    $('#pesquisa_categoria').on('change',function(){
        
        if (rowModel == null)
            rowModel = $('.pesquisa-row:first').clone();
        
        $('.anuncio-search').empty();
        $('.pesquisa_loading').css('display', 'block');

        $.ajax($('.pesquisa-control').data("info"), 
        {
            method: 'GET',
            type: 'json',
            data: 
                {
                    "titulo" : $("#pesquisa_titulo").val(), 
                    "categoria" : $("#pesquisa_categoria :selected").val(),
                    "regiao" : $("#pesquisa_regiao :selected").text(),
                },
        }).then(function(anuncios)
        {
            $.each(anuncios, function(i, anuncio) 
            {
                var row = rowModel.clone();

                $('#pesquisa_row_titulo', row).text(anuncio.titulo);
                
                $('.anuncio-search').append(row);

                $('.pesquisa_loading').css('display', 'none');
            });
        });
    });

    $('#pesquisa_regiao').on('change',function(){
        
        if (rowModel == null)
            rowModel = $('.pesquisa-row:first').clone();
        
        $('.anuncio-search').empty();
        $('.pesquisa_loading').css('display', 'block');

        $.ajax($('.pesquisa-control').data("info"), 
        {
            method: 'GET',
            type: 'json',
            data: 
                {
                    "titulo" : $("#pesquisa_titulo").val(), 
                    "categoria" : $("#pesquisa_categoria :selected").val(),
                    "regiao" : $("#pesquisa_regiao :selected").text(),
                },
        }).then(function(anuncios)
        {
            $.each(anuncios, function(i, anuncio) 
            {
                var row = rowModel.clone();

                $('#pesquisa_row_titulo', row).text(anuncio.titulo);
                
                $('.anuncio-search').append(row);

                $('.pesquisa_loading').css('display', 'none');
            });
        });
    });
    
});
