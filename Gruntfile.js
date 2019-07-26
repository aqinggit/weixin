//包装函数
module.exports=function(grunt){
    var bannerContent ='/*Copyright <%= pkg.author %>*/';


    //任务配置，所有插件的配置信息
    grunt.initConfig({
        //获取package.json的信息
        pkg : grunt.file.readJSON('package.json'),
        //js压缩处理
        uglify: {
            options: {
                banner: bannerContent
            },
            core:{
                files: [
                    {
                        expand: true,
                        cwd: 'jsCssSrc/coreJs/',
                        src: ['*.js'],
                        dest: 'common/coreJs/'
                    }
                ]
            },
            web: {
                files: [
                    {
                        expand: true,
                        cwd: 'jsCssSrc/web/js/',
                        src: ['*.js'],
                        dest: 'common/web/js/'
                    }
                ]
            },
            mobile: {
                files: [
                    {
                        expand: true,
                        cwd: 'jsCssSrc/mobile/js/',
                        src: ['*.js'],
                        dest: 'common/mobile/js/'
                    }
                ]
            },
            admin: {
                files: [
                    {
                        expand: true,
                        cwd: 'jsCssSrc/admin/js/',
                        src: ['*.js'],
                        dest: 'common/admin/js/'
                    }
                ]
            },
            mip: {
                files: [
                    {
                        expand: true,
                        cwd: 'jsCssSrc/mip/js/',
                        src: ['*.js'],
                        dest: 'common/mip/js/'
                    }
                ]
            }
        },
        //js语法提示
        jshint:{
            build:['Gruntfile.js','../jsCssSrc/js/*.js'],
            options:{
                jshintrc:'.jshintrc',
                mangle: {
                    except: ['jQuery']
                }
            }
        },

        csslint: {
            options: {
                csslintrc: '.csslintrc'
            },
            lax: {
                options: {
                    import: false
                },
                src: ['jsCssSrc/css/*.css']
            }
        },

        cssmin: {
            options: {
                banner: bannerContent
            },
            core: {
                files: [{
                    expand: true,
                    cwd: 'jsCssSrc/coreCss/',
                    src: ['*.css'],
                    dest: 'common/coreCss/'
                }]
            },
            web: {
                files: [
                    {
                        expand: true,
                        cwd: 'jsCssSrc/web/css/',
                        src: ['*.css'],
                        dest: 'common/web/css/'
                    }
                ]
            },
            mobile: {
                files: [
                    {
                        expand: true,
                        cwd: 'jsCssSrc/mobile/css/',
                        src: ['*.css'],
                        dest: 'common/mobile/css/'
                    }
                ]
            },
            admin: {
                files: [
                    {
                        expand: true,
                        cwd: 'jsCssSrc/admin/css/',
                        src: ['*.css'],
                        dest: 'common/admin/css/'
                    }
                ]
            },
            mip: {
                files: [
                    {
                        expand: true,
                        cwd: 'jsCssSrc/mip/css/',
                        src: ['*.css'],
                        dest: 'common/mip/css/'
                    }
                ]
            }
        },
        //合并js文件
        //concat: {
        //    options: {
        //        banner: bannerContent,
        //        //separator: ';',
        //        stripBanners: false
        //    },
        //    framework: {
        //        src: [
        //            '../common/css/bootstrap.min.css',
        //            '../common/css/font-awesome.min.css',
        //            '../common/css/font-awesome-ie7.min.css'
        //        ],
        //        dest: '../common/css/build.bootstrap.css'
        //    }
        //},

        imagemin: {                          // Task
            dynamic: {                         // Another target
                files: [{
                    expand: true,                  // Enable dynamic expansion
                    cwd: 'jsCssSrc/images/',                   // Src matches are relative to this path
                    src: ['**/*.{png,jpg,gif}'],   // Actual patterns to match
                    dest: 'common/images/'                  // Destination path prefix
                }]
            }
        },
        clean:{
          release:['common/css','common/js'],//每次重建时删除之前生成的文件
          build:['common/coreCss','common/coreJs']
        },

        watch:{
            build:{
                files:['jsCssSrc/js/*.js','jsCssSrc/css/*.css'],//../jsCssSrc/images/*.{png,jpg,gif}
                tasks:['clean:release','uglify:main','cssmin:target'],//jshint,csslint
                options:{
                    spawn:false
                }
            }
        }

    });

    grunt.loadNpmTasks("grunt-contrib-uglify");
    grunt.loadNpmTasks("grunt-contrib-jshint");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-csslint');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-newer');


    //告诉grunt当我们在终端输入grunt时要做什么（注意先后顺序）
    //在grunt命令执行时，要不要立即执行uglify插件？如果要，就写上，否则不写。
    //watch,jshint,csslint,watch,imagemin    
    grunt.registerTask('default',[
        'newer:cssmin:web',
        'newer:uglify:web',
        'newer:cssmin:mobile',
        'newer:uglify:mobile',
        'newer:cssmin:admin',
        'newer:uglify:admin',
        'newer:cssmin:mip',
        'newer:uglify:mip',
        'newer:cssmin:core',
        'newer:uglify:core',
        'newer:imagemin:dynamic'
    ]);

};