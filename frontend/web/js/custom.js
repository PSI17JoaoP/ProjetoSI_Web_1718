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
});


/*function addParameter (baseURL, idForm) {

    var categoriaOferta = $('#field-cat-oferta').val();
    var categoriaProcura = $('#field-cat-procura').val();

    if (categoriaOferta !== null && categoriaProcura === null){
        $.pjax.reload({
            url: baseURL + "?catOferta=" + categoriaOferta,
            container: idForm,
            timeout: 1000
        });
    }

    else if(categoriaProcura !== null && categoriaOferta === null) {
        $.pjax.reload({
            url:  baseURL + "?catProcura=" + categoriaProcura,
            container: idForm,
            timeout: 1000
        });
    }

    else {
        $.pjax.reload({
            url:  baseURL + "?catOferta=" + categoriaOferta + "&catProcura=" + categoriaProcura,
            container: idForm,
            timeout: 1000
        });
    }
}*/


