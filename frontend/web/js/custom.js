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
