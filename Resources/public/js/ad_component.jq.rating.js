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
        var iconBase = $(this).parent('span').data('icon-base');
        var iconCheck = $(this).parent('span').data('icon-check');

        $(inputHidden).val(valor);
        $(ratingLabel).html(label);

        $(this).parent("span").children("i").each(function(){
            if(parseInt($(this).data('rating'))<= valor ){
                $(this).removeClass(iconBase).addClass(iconCheck);
            }
            else {
                $(this).removeClass(iconCheck).addClass(iconBase);
            }
        });
    });

    rating.on('mousemove', 'i', function() {
        var valor=parseInt($(this).data('rating'));
        var label=$(this).data('rating-label');
        var ratingLabel = $(this).parent('span').children('.ad_component-rating-label')[0];
        var iconBase = $(this).parent('span').data('icon-base');
        var iconCheck = $(this).parent('span').data('icon-check');

        $(ratingLabel).html(label);

        $(this).parent("span").children("i").each(function(){
            if(parseInt($(this).data('rating'))<= valor ){
                $(this).removeClass(iconBase).addClass(iconCheck);
            }
            else {
                $(this).removeClass(iconCheck).addClass(iconBase);
            }
        });
    });

    rating.on('mouseout', 'i', function() {
        var inputHidden = $(this).parent('span').children("input[type='hidden']")[0];
        var ratingLabel = $(this).parent('span').children('.ad_component-rating-label')[0];
        var valor = parseInt($(inputHidden).val());
        var iconBase = $(this).parent('span').data('icon-base');
        var iconCheck = $(this).parent('span').data('icon-check');

        if(valor === NaN){
            $(ratingLabel).html('');
        }
        $(this).parent("span").children("i").each(function(){
            var rating_value= parseInt($(this).data('rating'));
            if(rating_value <= valor ){
                $(this).removeClass(iconBase).addClass(iconCheck);
                if(rating_value === valor){
                    $(ratingLabel).html($(this).data('rating-label'));
                }
            }
            else {
                $(this).removeClass(iconCheck).addClass(iconBase);
            }
        });
    });
});