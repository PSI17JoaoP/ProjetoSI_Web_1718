$(".rowListaUsers").click(function() 
{
    var id = $(this).data("id");
    var url = $(this).data("url");

    $.ajax(url, 
        {
            method: 'GET',
            type: 'json',
            data: 
                {
                    "id" : id,
                },
        }).then(function(detalhes)
        {
            $('#userAnuncios').empty();

            if(detalhes['cliente'] == null)
            {
                $("#userImage").attr('src', "");
                $("#userProfileName").html(detalhes['user']['username']);
                $("#userTelefone").empty();
                $("#userRegiao").empty();
            }else
            {
                if(detalhes['cliente']['path_imagem'] != null)
                {
                    $("#userImage").attr('src', "../../../common/images/"+detalhes['cliente']['path_imagem']);
                }else
                {
                    $("#userImage").attr('src', "");
                }

                $("#userProfileName").html(detalhes['cliente']['nome_completo']);
                $("#userTelefone").html(detalhes['cliente']['telefone']);
                $("#userRegiao").html(detalhes['cliente']['regiao']);

                detalhes['anuncios'].forEach(anuncio => {
                    var anuncioRow = $('<tr>').append(
                        $('<td>').text(anuncio['titulo']),
                    ).appendTo('#userAnuncios');
                });
            }            

            $("#userEmail").html(detalhes['user']['email']);
            
        });

})