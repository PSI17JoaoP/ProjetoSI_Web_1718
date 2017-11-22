$(function(){

    $('.showModal').click(function(){
        $('#modal_detalhes').modal('show');
    });

    $('#modal_cliente').ready(function(){
        $('.close').remove();
        $('#modal_cliente').modal('show');
    });

    $('#modal_detalhes').ready(function(){
        $('#modal_detalhes').modal('toggle');
    });

});





