/**
 * Created by claudio on 08-06-17.
 */
$(document).ready(function(){
    $('.ad_component-rating').on('click', 'i', function() {
        var valor=$(this).data('rating');
        $(this).parent('span').children("input[type='hidden']").each(function(){
            $(this).val(valor);
        });
        $(this).parent("span").children("i").each(function(){
            if(parseInt($(this).data('rating'))<= valor ){
                $(this).removeClass('fa-star-o').addClass('fa-star');
            }
            else {
                $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    });
});