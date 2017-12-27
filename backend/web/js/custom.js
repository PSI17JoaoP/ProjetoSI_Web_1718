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
            if(detalhes['cliente'] == null)
            {
                $("#userImage").attr('src', "../../web/assets/pic_placeholder.png");
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
                    $("#userImage").attr('src', "../../web/assets/pic_placeholder.png");
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
            
            $('.pesquisa_loading').css('display', 'none');
            $("#userInfo").css('display', "block");
        });
    
        $('#userAnuncios').empty();
            
        $("#userInfo").css('display', "none");
        $('.pesquisa_loading').css('display', 'block');
});

$("#pieChart").ready(function () 
{
    var url = $('#pieChart').data('info');

    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
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

$("#areaChart").ready(function()
{
    var url = $('#areaChart').data('info');
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {}

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : false
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)

    $.ajax(url, {
        method: 'GET',
        type: 'json',
    }).done(function(data)
    {
        
        areaChartData = {
            labels  : [],
            datasets: [
              {
                label               : 'Anúncios',
                fillColor           : 'rgba(60,141,188,0.9)',
                strokeColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : []
              }
            ]
          }

        data.forEach(mes => {
            areaChartData.labels.push(mes.mes)
            areaChartData.datasets[0].data.push(mes.count)
        });
       
        areaChart.Line(areaChartData, areaChartOptions)
    })
})