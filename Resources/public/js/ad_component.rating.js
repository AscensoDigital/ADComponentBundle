document.addEventListener('DOMContentLoaded', function () {
    var ratingContainers = document.querySelectorAll('.ad_component-rating');

    ratingContainers.forEach(function (container) {
        container.addEventListener('click', function (event) {
            if (event.target.tagName.toLowerCase() === 'i') {
                var icon = event.target;
                var span = icon.closest('span');
                var valor = parseInt(icon.dataset.rating);
                var label = icon.dataset.ratingLabel;
                var inputHidden = span.querySelector("input[type='hidden']");
                var ratingLabel = span.querySelector('.ad_component-rating-label');
                var iconBase = span.dataset.iconBase;
                var iconCheck = span.dataset.iconCheck;

                inputHidden.value = valor;
                ratingLabel.textContent = label;

                span.querySelectorAll('i').forEach(function (i) {
                    if (parseInt(i.dataset.rating) <= valor) {
                        i.classList.remove(iconBase);
                        i.classList.add(iconCheck);
                    } else {
                        i.classList.remove(iconCheck);
                        i.classList.add(iconBase);
                    }
                });
            }
        });

        container.addEventListener('mousemove', function (event) {
            if (event.target.tagName.toLowerCase() === 'i') {
                var icon = event.target;
                var span = icon.closest('span');
                var valor = parseInt(icon.dataset.rating);
                var label = icon.dataset.ratingLabel;
                var ratingLabel = span.querySelector('.ad_component-rating-label');
                var iconBase = span.dataset.iconBase;
                var iconCheck = span.dataset.iconCheck;

                ratingLabel.textContent = label;

                span.querySelectorAll('i').forEach(function (i) {
                    if (parseInt(i.dataset.rating) <= valor) {
                        i.classList.remove(iconBase);
                        i.classList.add(iconCheck);
                    } else {
                        i.classList.remove(iconCheck);
                        i.classList.add(iconBase);
                    }
                });
            }
        });

        container.addEventListener('mouseout', function (event) {
            if (event.target.tagName.toLowerCase() === 'i') {
                var icon = event.target;
                var span = icon.closest('span');
                var inputHidden = span.querySelector("input[type='hidden']");
                var ratingLabel = span.querySelector('.ad_component-rating-label');
                var valor = parseInt(inputHidden.value);
                var iconBase = span.dataset.iconBase;
                var iconCheck = span.dataset.iconCheck;

                ratingLabel.textContent = '';

                span.querySelectorAll('i').forEach(function (i) {
                    var ratingValue = parseInt(i.dataset.rating);
                    if (ratingValue <= valor) {
                        i.classList.remove(iconBase);
                        i.classList.add(iconCheck);
                        if (ratingValue === valor) {
                            ratingLabel.textContent = i.dataset.ratingLabel;
                        }
                    } else {
                        i.classList.remove(iconCheck);
                        i.classList.add(iconBase);
                    }
                });
            }
        });
    });
});
