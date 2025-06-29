describe('ADComponent (utils)', function() {

    // -------------------------------
    // Tests para msgAlert
    // -------------------------------
    describe('msgAlert', function() {
        it('should generate correct alert HTML', function() {
            var html = ADComponent.msgAlert('warning', '¡Atención!');
            expect(html).toContain('alert-warning');
            expect(html).toContain('¡Atención!');
        });

        it('should handle empty level and message', function() {
            var html = ADComponent.msgAlert('', '');
            expect(html).toContain('alert-info');
            expect(html).toContain('<div class="alert alert-info');
        });

        it('should handle null values', function() {
            var html = ADComponent.msgAlert(null, null);
            expect(html).toContain('alert-info');
            expect(html).toContain('<div class="alert alert-info');
        });

        it('should handle undefined values', function() {
            var html = ADComponent.msgAlert(undefined, undefined);
            expect(html).toContain('alert-info');
            expect(html).toContain('<div class="alert alert-info');
        });
    });

    // -------------------------------
    // Tests para msgLabel
    // -------------------------------
    describe('msgLabel', function() {
        it('should generate correct label HTML', function() {
            var html = ADComponent.msgLabel('Importante', 'info', 'Este es un mensaje');
            expect(html).toContain('label label-info');
            expect(html).toContain('Importante');
            expect(html).toContain('Este es un mensaje');
        });

        it('should handle empty label, level and message', function() {
            var html = ADComponent.msgLabel('', '', '');
            expect(html).toContain('label-info');
            expect(html).toContain('<span class="label label-info">');
        });

        it('should handle null values', function() {
            var html = ADComponent.msgLabel(null, null, null);
            expect(html).toContain('label-info');
            expect(html).toContain('<span class="label label-info">');
        });

        it('should handle undefined values', function() {
            var html = ADComponent.msgLabel(undefined, undefined, undefined);
            expect(html).toContain('label-info');
            expect(html).toContain('<span class="label label-info">');
        });
    });

    // -------------------------------
    // Tests para object2Array
    // -------------------------------
    describe('object2Array', function() {
        it('should return the same for flat objects', function() {
            var input = { x: 1, y: 'z' };
            var output = ADComponent.object2Array(input);
            expect(output).toEqual(input);
        });

        it('should recursively convert nested objects', function() {
            var input = {
                a: 'hola',
                b: { c: 1, d: { e: 2 } }
            };
            var output = ADComponent.object2Array(input);
            expect(output.a).toBe('hola');
            expect(typeof output.b).toBe('object');
            expect(output.b.c).toBe(1);
            expect(output.b.d.e).toBe(2);
        });

        it('should handle empty object', function() {
            var output = ADComponent.object2Array({});
            expect(output).toEqual({});
        });

        it('should return null for null input', function() {
            var result = ADComponent.object2Array(null);
            expect(result).toBe(null);
        });

        it('should return input for non-object (string)', function() {
            var result = ADComponent.object2Array('hola');
            expect(result).toBe('hola');
        });

        it('should return input for non-object (number)', function() {
            var result = ADComponent.object2Array(42);
            expect(result).toBe(42);
        });

        it('should return input for arrays (not recurse)', function() {
            var arr = [1, 2, 3];
            var result = ADComponent.object2Array(arr);
            expect(result).toBe(arr);
        });

        it('should skip inherited properties', function() {
            function Custom() {
                this.a = 1;
            }
            Custom.prototype.b = 2;
            var obj = new Custom();
            var result = ADComponent.object2Array(obj);
            expect(result.a).toBe(1);
            expect(result.b).toBeUndefined();
        });

        it('should not modify functions', function() {
            var obj = {
                a: 1,
                b: function() { return 42; }
            };
            var result = ADComponent.object2Array(obj);
            expect(typeof result.b).toBe('function');
        });
    });

});
