module.exports = function(grunt) {
    grunt.initConfig({
        clean: {
            assets: ['assets']
        },
        uglify: {
            main: {
                src: 'resources/js/formValidation.js',
                dest: 'assets/js/form-validation.min.js'
            }
        },
        sass: {
            'main-css': {
                options: {
                    noCache: true,
                    sourcemap: 'none',
                    style: 'expanded'
                },
                files: {
                    'assets/css/site.css': 'resources/scss/site.scss'
                }
            }
        },
        concat: {
            'main-css': {
                src: [
                    'bower_components/skeleton/css/normalize.css',
                    'bower_components/skeleton/css/skeleton.css',
                    'assets/css/site.css'                    
                ],
                dest: 'assets/css/main.css'
            }
        },
        cssmin: {
            'main-css': {
                files: {
                    'assets/css/main.min.css': ['assets/css/main.css']
                }
            }
        }
    });

    // Plugins
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-sass');

    // Build task
    grunt.registerTask('build', ['clean', 'sass', 'concat', 'cssmin', 'uglify']);
};