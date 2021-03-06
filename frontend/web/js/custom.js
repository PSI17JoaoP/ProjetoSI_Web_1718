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
                $('.modal_rating').css('display', 'none');

                $.ajax(detalhesUrl, {
                    method: 'GET',
                    type: 'json',
                    data: 
                    {
                        "id" : detalhesId,
                    }
                }).then(function(data){
                    var content = "<h3>Título: "+data[0].titulo+"<small>  Criado a: "+data[0].data_criacao+"</small></h3>";

                    if (data[6] >= 75) {
                        content += "<p class='text-success'>Pontuação:"+data[6]+"%</p>";
                    }else if (data[6] < 50) {
                        content += "<p class='text-danger'>Pontuação:"+data[6]+"%</p>";
                    }else{
                        content += "<p class='text-primary'>Pontuação:"+data[6]+"%</p>";
                    }

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

                    $('#btn-rate').attr("data-id", data[0].id_user);
                    
                    $("#reportSim").attr('data-id', data[0].id);

                    $('.modal_detalhes').append(content);

                    $('.pesquisa_loading_modal').css('display', 'none');

                    if (data[5] == true) {
                        $('.modal_rating').css('display', 'block');
                        $("#reportOpt").css('display', "none");
                    }   
                    
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

    $("#btn-rate").on('click', function()
    {
        var detalhesUrl = $(this).data("detail");
        var idCliente = $(this).data("id");
        var score = $("#rate").val();

        $.ajax(detalhesUrl, {
            method: 'GET',
            type: 'json',
            data: 
            {
                "id_cliente" : idCliente,
                "score" : score
            }
        }).then(function(response){
            $('.filled-stars').css("width", "0%");
            if (response == true) {
                $('.modal_rating').css('display', 'none');
                $('.modal_detalhes').append("<p class='text-success'>Votado com sucesso!</p>");
            }else{
                $('.modal_detalhes').append("<p class='text-danger'>Erro ao votar</p>");
            }
        });
    });
    
    $('#reportShow').click(function()
    {
        $("#reportOpt").css('display', "inline-block");
    });

    $('#reportNao').click(function()
    {
        $("#reportOpt").css('display', "none");
    });

    $('#reportSim').click(function()
    {
        var detalhesUrl = $(this).data("href");
        var idAnuncio = $(this).data("id");

        $.ajax(detalhesUrl, {
            method: 'GET',
            type: 'json',
            data: 
            {
                "id" : idAnuncio
            }
        }).then(function(response){
            if (response == true) {
                $('.modal_rating').css('display', 'none');
                $('.modal_detalhes').append("<p class='text-success'>Reportado com sucesso!</p>");
            }else{
                $('.modal_detalhes').append("<p class='text-danger'>Erro ao reportar</p>");
            }
        });
    });

    $('#pesquisa_titulo').on('input',function(){
        pesquisa();
    });

    $('#pesquisa_categoria').on('change',function(){
        pesquisa();
    });

    $('#pesquisa_regiao').on('change', function(){
        pesquisa();
    });
    
});

//##########################################
//Pesquisa
//##########################################

var rowModel = null;

function pesquisa()
{
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
    
                    $('#pesquisa_row_imagem', row).attr('src', "../../../common/images/"+anuncio.path_relativo);

                    $('#pesquisa_row_titulo', row).html("<b>Título: </b>"+anuncio.titulo);
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
};
