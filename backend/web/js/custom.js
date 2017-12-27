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
                        $('<td>').text(anuncio['cat_oferecer']),
                        $('<td>').text(anuncio['cat_receber']),
                        $('<td>').text(anuncio['nPropostas']),
                    ).appendTo('#userAnuncios');
                });
            }            

            $("#userEmail").html(detalhes['user']['email']);
            
        });

});
$("#indexPieChart").ready(function () 
{
    var url = $('#indexPieChart').data('info');

    var pieChartCanvas = $('#indexPieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)

    var pieOptions     = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke    : true,
        //String - The colour of each segment stroke
        segmentStrokeColor   : '#fff',
        //Number - The width of each segment stroke
        segmentStrokeWidth   : 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps       : 100,
        //String - Animation easing effect
        animationEasing      : 'easeOutBounce',
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate        : true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale         : false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive           : true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio  : true,
        //String - A legend template
        legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
      }

    var PieData = [];
    
    pieChart.Doughnut(PieData, pieOptions)


    $.ajax(url, {
        method: 'GET',
        type: 'json',
    }).done(function(data)
    {
        
        PieData = [
          {
            value    : data[0].brinquedos,
            color    : '#f56954',
            highlight: '#f56954',
            label    : 'Brinquedos'
          },
          {
            value    : data[1].jogos,
            color    : '#00a65a',
            highlight: '#00a65a',
            label    : 'Jogos'
          },
          {
            value    : data[2].eletronica,
            color    : '#f39c12',
            highlight: '#f39c12',
            label    : 'Eletrónica'
          },
          {
            value    : data[3].computadores,
            color    : '#00c0ef',
            highlight: '#00c0ef',
            label    : 'Computadores'
          },
          {
            value    : data[4].smartphones,
            color    : '#3c8dbc',
            highlight: '#3c8dbc',
            label    : 'SmartPhones'
          },
          {
            value    : data[5].livros,
            color    : '#d2d6de',
            highlight: '#d2d6de',
            label    : 'Livros'
          },
          {
            value    : data[6].roupa,
            color    : '#1460a6',
            highlight: '#1460a6',
            label    : 'Roupa'
          }
        ]
       
        pieChart.Doughnut(PieData, pieOptions)
    })

})