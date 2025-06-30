describe('ADComponent rating con JavaScript vainilla', function () {
    beforeEach(function () {
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

        // Cargar el script vanilla
        require('../../Resources/public/js/ad_component.rating.js');

        // Simular carga de DOM si hiciera falta (DOMContentLoaded ya se disparó en jsdom)
        document.dispatchEvent(new Event('DOMContentLoaded'));
    });

    it('debe actualizar el valor y las clases al hacer click', function () {
        const stars = document.querySelectorAll('i');
        stars[1].click(); // clic en rating 2

        expect(stars[0].classList.contains('fa-star')).toBe(true);
        expect(stars[1].classList.contains('fa-star')).toBe(true);
        expect(stars[2].classList.contains('fa-star-o')).toBe(true);

        const input = document.querySelector("input[type='hidden']");
        expect(input.value).toBe("2");

        const label = document.querySelector('.ad_component-rating-label');
        expect(label.textContent).toBe("Regular");
    });

    it('debe mostrar el label correspondiente al hacer hover', function () {
        const stars = document.querySelectorAll('i');
        const event = new Event('mousemove', { bubbles: true });
        stars[2].dispatchEvent(event); // hover sobre 3

        expect(stars[2].classList.contains('fa-star')).toBe(true);

        const label = document.querySelector('.ad_component-rating-label');
        expect(label.textContent).toBe("Bueno");
    });

    it('debe restaurar el valor y label al salir del hover', function () {
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

    it('debe apagar estrellas si se baja el hover desde una alta', function () {
        const stars = document.querySelectorAll('i');

        // Paso 1: simular hover sobre la estrella 3
        stars[2].dispatchEvent(new Event('mousemove', { bubbles: true }));
        expect(stars[0].classList.contains('fa-star')).toBe(true);
        expect(stars[1].classList.contains('fa-star')).toBe(true);
        expect(stars[2].classList.contains('fa-star')).toBe(true);

        // Paso 2: simular hover hacia abajo, sobre estrella 1
        stars[0].dispatchEvent(new Event('mousemove', { bubbles: true }));
        expect(stars[0].classList.contains('fa-star')).toBe(true);
        expect(stars[1].classList.contains('fa-star-o')).toBe(true); // ← apagada
        expect(stars[2].classList.contains('fa-star-o')).toBe(true); // ← apagada

        const label = document.querySelector('.ad_component-rating-label');
        expect(label.textContent).toBe("Malo");
    });

    it('debe dejar todo apagado si no hay selección previa y se hace mouseout', function () {
        const stars = document.querySelectorAll('i');

        // Asegurarse que el hidden value esté vacío o en 0
        const input = document.querySelector("input[type='hidden']");
        input.value = "0";

        // Hover y salir
        stars[2].dispatchEvent(new Event('mousemove', { bubbles: true }));
        stars[2].dispatchEvent(new Event('mouseout', { bubbles: true }));

        // Todas deben estar apagadas (fa-star-o)
        expect(stars[0].classList.contains('fa-star-o')).toBe(true);
        expect(stars[1].classList.contains('fa-star-o')).toBe(true);
        expect(stars[2].classList.contains('fa-star-o')).toBe(true);

        // Label debe estar vacío
        const label = document.querySelector('.ad_component-rating-label');
        expect(label.textContent).toBe('');
    });

});
