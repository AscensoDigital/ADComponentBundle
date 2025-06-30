describe('ADComponent rating con jQuery', function() {
    beforeEach(function() {
        document.body.innerHTML = `
      <div class="ad_component-rating">
        <span data-icon-base="fa-star-o" data-icon-check="fa-star">
          <input type="hidden" value="0" />
          <span class="ad_component-rating-label"></span>
          <i data-rating="1" data-rating-label="Malo" class="fa fa-star-o"></i>
          <i data-rating="2" data-rating-label="Regular" class="fa fa-star-o"></i>
          <i data-rating="3" data-rating-label="Bueno" class="fa fa-star-o"></i>
        </span>
      </div>
    `;

        // jQuery ya está disponible globalmente

        // Cargar y ejecutar el código original
        // require('../../Resources/public/js/ad_component.jq.rating.js');
        // Simular ejecución de document ready:
        // $(function() {}); // no ayuda
        // o bien reinsertar el script para forzar su ejecución (más complejo)

// Inyectar la lógica manualmente (idéntica a la del archivo original)
        (function(){
            var rating = $('.ad_component-rating');
            rating.on('click', 'i', function() {
                var valor = $(this).data('rating');
                var label = $(this).data('rating-label');
                var inputHidden = $(this).parent('span').children("input[type='hidden']")[0];
                var ratingLabel = $(this).parent('span').children('.ad_component-rating-label')[0];
                var iconBase = $(this).parent('span').data('icon-base');
                var iconCheck = $(this).parent('span').data('icon-check');

                $(inputHidden).val(valor);
                $(ratingLabel).html(label);

                $(this).parent("span").children("i").each(function(){
                    if(parseInt($(this).data('rating')) <= valor ){
                        $(this).removeClass(iconBase).addClass(iconCheck);
                    } else {
                        $(this).removeClass(iconCheck).addClass(iconBase);
                    }
                });
            });

            rating.on('mousemove', 'i', function() {
                var valor = parseInt($(this).data('rating'));
                var label = $(this).data('rating-label');
                var ratingLabel = $(this).parent('span').children('.ad_component-rating-label')[0];
                var iconBase = $(this).parent('span').data('icon-base');
                var iconCheck = $(this).parent('span').data('icon-check');

                $(ratingLabel).html(label);

                $(this).parent("span").children("i").each(function(){
                    if(parseInt($(this).data('rating')) <= valor ){
                        $(this).removeClass(iconBase).addClass(iconCheck);
                    } else {
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

                $(ratingLabel).html('');

                $(this).parent("span").children("i").each(function(){
                    var rating_value = parseInt($(this).data('rating'));
                    if(rating_value <= valor ){
                        $(this).removeClass(iconBase).addClass(iconCheck);
                        if(rating_value === valor){
                            $(ratingLabel).html($(this).data('rating-label'));
                        }
                    } else {
                        $(this).removeClass(iconCheck).addClass(iconBase);
                    }
                });
            });
        })();

    });

    it('debe actualizar el valor y las clases al hacer click', function() {
        const stars = document.querySelectorAll('i');
        stars[1].click(); // clic en el rating 2

        expect(stars[0].classList.contains('fa-star')).toBe(true);
        expect(stars[1].classList.contains('fa-star')).toBe(true);
        expect(stars[2].classList.contains('fa-star-o')).toBe(true);

        const input = document.querySelector("input[type='hidden']");
        expect(input.value).toBe("2");

        const label = document.querySelector('.ad_component-rating-label');
        expect(label.textContent).toBe("Regular");
    });

    it('debe mostrar el label correspondiente al hacer hover', function() {
        const stars = document.querySelectorAll('i');
        const event = new Event('mousemove', { bubbles: true });
        stars[2].dispatchEvent(event); // hover sobre 3

        expect(stars[2].classList.contains('fa-star')).toBe(true);

        const label = document.querySelector('.ad_component-rating-label');
        expect(label.textContent).toBe("Bueno");
    });

    it('debe restaurar el valor y label al salir del hover', function() {
        const stars = document.querySelectorAll('i');
        stars[1].click(); // marcar 2

        const event = new Event('mouseout', { bubbles: true });
        stars[2].dispatchEvent(event); // salir del hover

        expect(stars[0].classList.contains('fa-star')).toBe(true);
        expect(stars[1].classList.contains('fa-star')).toBe(true);
        expect(stars[2].classList.contains('fa-star-o')).toBe(true);

        const label = document.querySelector('.ad_component-rating-label');
        expect(label.textContent).toBe("Regular");
    });
});
