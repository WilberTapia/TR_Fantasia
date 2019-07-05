
$(document).on('ready', function(){
    $('.AjaxForm').on('submit',function(e) {
        e.preventDefault();
        var datos=$(this).serialize();
        var metodo=$(this).attr('method');
        var action=$(this).attr('action');
        $.ajax({
            type: metodo,
            url: action,
            data: datos,
            beforeSend: function(){
                $('.msjRespuesta').html(MsjEnviando);
            },
            error: function() {
                $('.msjRespuesta').html(MsjError);
            },
            success: function (data) {
                $('.msjRespuesta').html(data);
            }
        });
        return false;
    });
});
