module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        copy: {
            main: {
                files: [     
                    // bootstrap files
                    {src: ['src/assets/bootstrap/bootstrap/js/**'], dest: 'releases/'},
                    {src: ['src/assets/bootstrap/bootstrap/less/**'], dest: 'releases/'},
                    {src: ['src/assets/bootstrap/bootstrap/fonts/**'], dest: 'releases/'},
                    {src: ['src/assets/bootstrap/bootstrap/dist/**'], dest: 'releases/'},
                    {src: ['src/assets/bootstrap/bootstrap/LICENSE'], dest: 'releases/'},
                    {src: ['src/assets/bootstrap/bootstrap/LICENSE'], dest: 'releases/'},
                    {src: ['src/assets/bootstrap/bootstrap/assets/js/html5shiv.js'], dest: 'releases/', filter: 'isFile'},
                    {src: ['src/assets/bootstrap/bootstrap/assets/js/respond.min.js'], dest: 'releases/', filter: 'isFile'},
                    
                    // bootstrap select
                    {src: ['src/assets/bootstrap/bootstrap-select/**'], dest: 'releases/'},

                    // jquery-touchSwipe
                    {src: ['src/assets/bootstrap/jquery-touchSwipe/jquery.touchSwipe.min.js'], dest: 'releases/', filter: 'isFile'},
                    {src: ['src/assets/bootstrap/jquery-touchSwipe/README.md'], dest: 'releases/', filter: 'isFile'}

                ]
            }
        }
    });


    grunt.loadNpmTasks('grunt-contrib-copy');

    grunt.registerTask('default', ['copy']);

};