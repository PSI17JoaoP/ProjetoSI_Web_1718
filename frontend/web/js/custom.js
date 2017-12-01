$(function(){
    $('#modal_geral').ready(function(){

        jQuery.fn.exists = function(){ return this.length > 0; };

        if($('#cliente-form').exists()) {
            $('.close').remove();
            $('#modal_geral').modal('show');
        }

        else {
            $('.view_model').click(function () {
                $('#modal_geral').modal('toggle');
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
            });
        });
    });

    $('#pesquisa_categoria').on('change',function(){
        
        if (rowModel == null)
            rowModel = $('.pesquisa-row:first').clone();
        
        $('.anuncio-search').empty();

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
            });
        });
    });

    $('#pesquisa_regiao').on('change',function(){
        
        if (rowModel == null)
            rowModel = $('.pesquisa-row:first').clone();
        
        $('.anuncio-search').empty();

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
            });
        });
    });
    
});
