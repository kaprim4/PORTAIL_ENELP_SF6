const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build/')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    .copyFiles({
        from: './assets/images',
        // optional target path, relative to the output dir
        to: 'assets/images/[path][name].[ext]',
        // if versioning is enabled, add the file hash too
        //to: 'images/[path][name].[hash:8].[ext]',

        // only copy files matching this pattern
        //pattern: /\.(png|jpg|jpeg)$/
    })
    /*.copyFiles({
        from: './assets/js',
        to: 'assets/js/[path][name].[ext]',
        pattern: /\.(js)$/
    })
    .copyFiles({
        from: './assets/css',
        to: 'assets/css/[path][name].[ext]',
        pattern: /\.(css)$/
    })
    .copyFiles({
        from: './assets/fonts',
        to: 'assets/fonts/[path][name].[ext]',
    })
    .copyFiles({
        from: './assets/json',
        to: 'assets/json/[path][name].[ext]',
        pattern: /\.(json)$/
    })*/

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */

    .addStyleEntry('assets/libs/swiper/swiper-bundle.min', './assets/libs/swiper/swiper-bundle.min.css')
    .addStyleEntry('assets/css/bootstrap.min', './assets/css/bootstrap.min.css')
    .addStyleEntry('assets/libs/multi.js/multi.min.css', './assets/libs/multi.js/multi.min.css')
    .addStyleEntry('assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css', './assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css')
    .addStyleEntry('assets/css/theme_css', [
        './node_modules/select2/dist/css/select2.min.css',
        './node_modules/multi.js/dist/multi.min.css',
        './assets/css/app.min.css',
        './assets/css/icons.min.css',
        './assets/css/custom.min.css',
        './assets/libs/dropzone/dropzone.css',
    ])
    .addStyleEntry('assets/css/datatables.css', [
        './assets/libs/datatables/css/dataTables.bootstrap5.min.css',
        './assets/libs/datatables/css/responsive.bootstrap.min.css',
        './assets/libs/datatables/css/buttons.dataTables.min.css',
    ])
    .addStyleEntry('assets/libs/apexcharts/apexcharts.css', './node_modules/apexcharts/dist/apexcharts.css')




    .addEntry('assets/libs/bootstrap/js/bootstrap.bundle.min', './assets/libs/bootstrap/js/bootstrap.bundle.min.js')
    .addEntry('assets/js/plugins', [
        './assets/libs/simplebar/simplebar.min.js',
        './assets/libs/node-waves/waves.min.js',
        './assets/libs/feather-icons/feather.min.js',
        './assets/js/pages/plugins/lord-icon-2.1.0.js',
        './assets/libs/swiper/swiper-bundle.min.js',
        './node_modules/select2/dist/js/select2.full.min.js',
        './assets/libs/countdown/jquery.countdown.min.js',
    ])
    .addEntry('assets/libs/@ckeditor/ckeditor', [
        './assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js',
    ])
    .addEntry('assets/libs/dropzone/dropzone', [
        './assets/libs/dropzone/dropzone-min.js',
    ])
    .addEntry('assets/libs/multi.js/multi.min.js', [
        './assets/libs/multi.js/multi.min.js',
        './assets/js/pages/form-advanced.init.js',
    ])
    .addEntry('assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js', [
        './assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js',
    ])
    .addEntry('assets/js/pages/form-advanced.init', [
        './assets/js/pages/form-advanced.init.js',
    ])
    .addEntry('assets/js/pages/project-create.init', [
        './assets/js/pages/project-create.init.js',
    ])
    .addEntry('assets/js/pages/mailbox.init', [
        './assets/js/pages/mailbox.init.js',
    ])
    .addEntry('assets/js/layout', './assets/js/layout.js')
    .addEntry('assets/js/pages/dashboard-ecommerce.init', './assets/js/pages/dashboard-ecommerce.init.js')
    .addEntry('assets/libs/datatables/js/datatables.js', [
        './assets/libs/datatables/js/jquery.dataTables.min.js',
        './assets/libs/datatables/js/dataTables.bootstrap5.min.js',
        './assets/libs/datatables/js/dataTables.responsive.min.js',
        './assets/libs/datatables/js/dataTables.buttons.min.js',
        './assets/libs/datatables/js/buttons.print.min.js',
        './assets/libs/datatables/js/buttons.html5.min.js',
        //'./assets/libs/datatables/js/vfs_fonts.js',
        //'./assets/libs/datatables/js/pdfmake.min.js',
        //'./assets/libs/datatables/js/jszip.min.js',
        './assets/js/pages/datatables.init.js',
    ])
    .addEntry('assets/libs/apexcharts/apexcharts.js', [
        './node_modules/apexcharts/dist/apexcharts.min.js',
        './assets/js/pages/apexcharts.init.js',
    ])
    .addEntry('assets/js/app', [
        './assets/js/app.js',
    ])

    //login
    .addEntry('assets/libs/particles.js/particles', './assets/libs/particles.js/particles.js')
    .addEntry('assets/js/pages/particles.app', './assets/js/pages/particles.app.js')
    .addEntry('assets/js/pages/password-addon.init', './assets/js/pages/password-addon.init.js')

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    //.splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()
    //.disableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();

