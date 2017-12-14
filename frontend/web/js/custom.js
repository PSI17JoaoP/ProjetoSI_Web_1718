$(function(){
    $('#modal_geral').ready(function(){

        jQuery.fn.exists = function(){ return this.length > 0; };

        if($('#cliente-form').exists()) {
            $('.close').remove();
            $('#modal_geral').modal('show');
        }

        else {
            $('.anuncio-detalhes').on('click', '.view_model' ,function () {
                var detalhesUrl = $(this).data("detail");
                var detalhesId = $(this).data("id");

                $('.modal_detalhes').empty();

                $.ajax(detalhesUrl, {
                    method: 'GET',
                    type: 'json',
                    data: 
                    {
                        "id" : detalhesId,
                    }
                }).then(function(data){
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

                    $('.pesquisa_loading_modal').css('display', 'none');
                });

                $('#modal_geral').modal('toggle');

                $('.pesquisa_loading_modal').css('display', 'block');
            });
        }

        $('.contactos-detalhes').on('click', '.view_details' ,function () {
            var idUser = $(this).data("iduser");
            var idUserProposta = $(this).data("iduserproposta");
            var url = $(this).data("detail");

            $('.modal_detalhes').empty();

            $.ajax(url, {
                method: 'GET',
                type: 'json',
                data: 
                {
                    "idUser" : idUser,
                    "idUserProposta" : idUserProposta,
                }
            }).then(function(data){
                var content = "<h3>Detalhes de contato</h3>";

                content += "Meu nome: "+data[0].nome_completo;
                content += "<br>";
                content += "Nome do autor da proposta: "+data[1].nome_completo;
                content += "<br>";
                content += "Telefone: "+data[1].telefone;
                content += "<br>";
                content += "Região: "+data[1].regiao;


                $('.modal_detalhes').append(content);

                $('.pesquisa_loading_modal').css('display', 'none');
            });

            $('#modal_geral').modal('toggle');
            
            $('.pesquisa_loading_modal').css('display', 'block');
        });
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
            $('.anuncio-search').empty();
            
            if (anuncios.length == 0) 
            {
                var noResults = "<div align='center'><p>Parece que não há nenhum anúncio...</p><p>Tente pesquisar com outros filtros</p></div>"
                $('.anuncio-search').append(noResults);

                $('.pesquisa_loading').css('display', 'none');    
            } else {
                $.each(anuncios, function(i, anuncio) 
                {
                    var row = rowModel.clone();
    
                    $('#pesquisa_row_titulo', row).text(anuncio.titulo);
                    $('#pesquisa_row_detalhes', row).attr('data-id', anuncio.id);
                    
    
                    var baseUrl = $('#pesquisa_row_proposta', row).attr('data-baseUrl');
                
                    $('#pesquisa_row_proposta', row).attr('href', baseUrl+"?anuncio="+anuncio.id);
                    
                    if (anuncio.cat_receber != null) 
                    {
                        $('#pesquisa_row_proposta', row).attr('data-params', "{id_anuncio: "+anuncio.id+"}");
                    }
                    
                    $('.anuncio-search').append(row);
    
                    $('.pesquisa_loading').css('display', 'none');
                });
            }
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
            if (anuncios.length == 0) 
            {
                var noResults = "<div align='center'><p>Parece que não há nenhum anúncio...</p><p>Tente pesquisar com outros filtros</p></div>"
                $('.anuncio-search').append(noResults);

                $('.pesquisa_loading').css('display', 'none');    
            } else {
                $.each(anuncios, function(i, anuncio) 
                {
                    var row = rowModel.clone();
    
                    $('#pesquisa_row_titulo', row).text(anuncio.titulo);
                    $('#pesquisa_row_detalhes', row).attr('data-id', anuncio.id);
                    
    
                    var baseUrl = $('#pesquisa_row_proposta', row).attr('data-baseUrl');
                
                    $('#pesquisa_row_proposta', row).attr('href', baseUrl+"?anuncio="+anuncio.id);
                    
                    if (anuncio.cat_receber != null) 
                    {
                        $('#pesquisa_row_proposta', row).attr('data-params', "{id_anuncio: "+anuncio.id+"}");
                    }
                    
                    $('.anuncio-search').append(row);
    
                    $('.pesquisa_loading').css('display', 'none');
                });
            }
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
            if (anuncios.length == 0) 
            {
                var noResults = "<div align='center'><p>Parece que não há nenhum anúncio...</p><p>Tente pesquisar com outros filtros</p></div>"
                $('.anuncio-search').append(noResults);

                $('.pesquisa_loading').css('display', 'none');    
            } else {
                $.each(anuncios, function(i, anuncio) 
                {
                    var row = rowModel.clone();
    
                    $('#pesquisa_row_titulo', row).text(anuncio.titulo);
                    $('#pesquisa_row_detalhes', row).attr('data-id', anuncio.id);
                    
    
                    var baseUrl = $('#pesquisa_row_proposta', row).attr('data-baseUrl');
                
                    $('#pesquisa_row_proposta', row).attr('href', baseUrl+"?anuncio="+anuncio.id);
                    
                    if (anuncio.cat_receber != null) 
                    {
                        $('#pesquisa_row_proposta', row).attr('data-params', "{id_anuncio: "+anuncio.id+"}");
                    }
                    
                    $('.anuncio-search').append(row);
    
                    $('.pesquisa_loading').css('display', 'none');
                });
            }
        });
    });
    
});
