/**
 * 
 */
$(function(){
    $('.getbyid span.button').live('click', function(e){
       $.ajax({
            url: "/ajax/getbyid",
            data : { id : $('.getbyid input').val() },
            success: function(xhr){
                $('.getbyid .result_block').html(xhr);
            }
        });
        e.preventDefault();
    });
});