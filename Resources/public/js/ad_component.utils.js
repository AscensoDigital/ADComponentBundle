var ADComponent = {
    /**
     * Genera un alert Bootstrap con el mensaje dado y el nivel de alerta.
     * Si el nivel no es válido, se usa "info" por defecto.
     */
    msgAlert: function(level, msg) {
        var validLevels = ['info', 'success', 'warning', 'danger'];

        if (typeof level !== 'string' || validLevels.indexOf(level) === -1) {
            level = 'info';
        }

        if (msg === null || msg === undefined) {
            msg = '';
        }

        return '<div class="alert alert-' + level + ' alert-dismissible" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span></button> ' + msg + '</div>';
    },

    /**
     * Genera un label Bootstrap seguido de un mensaje adicional.
     * Si no se entrega nivel, se usa "info" por defecto.
     */
    msgLabel: function(label, level, msg) {
        var validLevels = ['info', 'success', 'warning', 'danger'];

        if (typeof level !== 'string' || validLevels.indexOf(level) === -1) {
            level = 'info';
        }

        if (label === null || label === undefined) {
            label = '';
        }

        if (msg === null || msg === undefined) {
            msg = '';
        }

        var clase = 'label label-' + level;
        return '<span class="' + clase + '">' + label + '</span><br><div>' + msg + '</div>';
    },

    /**
     * Convierte objetos anidados en nuevos objetos,
     * aplicando la conversión de forma recursiva si hay objetos dentro.
     * No procesa arrays ni tipos primitivos.
     */
    object2Array: function(obj) {
        if (obj === null || typeof obj !== 'object' || Array.isArray(obj)) {
            return obj;
        }

        var ret = {};
        for (var prop in obj) {
            if (Object.prototype.hasOwnProperty.call(obj, prop)) {
                if (typeof obj[prop] === 'object' && obj[prop] !== null && !Array.isArray(obj[prop])) {
                    ret[prop] = this.object2Array(obj[prop]);
                } else {
                    ret[prop] = obj[prop];
                }
            }
        }
        return ret;
    }
};
