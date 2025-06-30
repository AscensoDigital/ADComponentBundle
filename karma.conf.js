module.exports = function(config) {
    config.set({
        basePath: '',
        frameworks: ['jasmine'],
        files: [
            'vendor/components/jquery/jquery-3.0.0.js',
            // Cargar como script puro
            {
                pattern: 'Resources/public/js/ad_component.utils.js',
                included: true,
                served: true,
                watched: false
            },
            {
                pattern: 'Resources/public/js/ad_component.jq.rating.js',
                included: true,
                served: true,
                watched: false
            },
            {
                pattern: 'Resources/public/js/ad_component.rating.js',
                    included: true,
                served: true,
                watched: false
            },
            // Archivos de prueba (sí usan Webpack)
            {
                pattern: 'tests/js/**/*.spec.js',
                included: true
            }
        ],
        preprocessors: {
            'Resources/public/js/ad_component.utils.js': ['coverage'],
            'Resources/public/js/ad_component.jq.rating.js': ['coverage'],
            'Resources/public/js/ad_component.rating.js': ['coverage'],
            'tests/js/**/*.spec.js': ['webpack', 'sourcemap']
        },
        plugins: [
            'karma-jasmine',
            'karma-chrome-launcher',
            'karma-webpack',
            'karma-sourcemap-loader',
            'karma-coverage'
        ],
        coverageReporter: {
            type: 'html',
            dir: 'coverage/',
            subdir: '.',
            includeAllSources: true
        },
        webpack: {
            mode: 'development',
            devtool: 'inline-source-map'
        },
        browsers: ['ChromeHeadless'],
        reporters: ['progress', 'coverage'],
        singleRun: true
    });
};
