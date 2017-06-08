/**
 * Created by claudio on 08-06-17.
 */
$(document).ready(function(){
    var rating=$('.ad_component-rating');
    rating.on('click', 'i', function() {
        var valor=$(this).data('rating');
        var label=$(this).data('rating-label');
        var inputHidden = $(this).parent('span').children("input[type='hidden']")[0];
        var ratingLabel = $(this).parent('span').children('.ad_component-rating-label')[0];

        $(inputHidden).val(valor);
        $(ratingLabel).html(label);

        $(this).parent("span").children("i").each(function(){
            if(parseInt($(this).data('rating'))<= valor ){
                $(this).removeClass('fa-star-o').addClass('fa-star');
            }
            else {
                $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    });

    rating.on('mousemove', 'i', function() {
        var valor=parseInt($(this).data('rating'));
        var label=$(this).data('rating-label');
        var ratingLabel = $(this).parent('span').children('.ad_component-rating-label')[0];

        $(ratingLabel).html(label);

        $(this).parent("span").children("i").each(function(){
            if(parseInt($(this).data('rating'))<= valor ){
                $(this).removeClass('fa-star-o').addClass('fa-star');
            }
            else {
                $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    });

    rating.on('mouseout', 'i', function() {
        var inputHidden = $(this).parent('span').children("input[type='hidden']")[0];
        var ratingLabel = $(this).parent('span').children('.ad_component-rating-label')[0];
        var valor = parseInt($(inputHidden).val());

        $(this).parent("span").children("i").each(function(){
            var rating_value= parseInt($(this).data('rating'));
            if(rating_value <= valor ){
                $(this).removeClass('fa-star-o').addClass('fa-star');
                if(rating_value === valor){
                    $(ratingLabel).html($(this).data('rating-label'));
                }
            }
            else {
                $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    });
});