/* eslint-disable */

import Encore from '@symfony/webpack-encore';
import fs from 'fs-extra';
import _ from 'lodash';
import path from 'path';

const dirname = import.meta.dirname;

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/assets/')
    // public path used by the web server to access the output path
    .setPublicPath('/assets')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('assets/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    //.addEntry('app', './assets/app.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // enables the Symfony UX Stimulus bridge (used in assets/stimulus_bootstrap.js)
    //.enableStimulusBridge('./assets/controllers.json')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()

    // Displays build status system notifications to the user
    // .enableBuildNotifications()

    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())


    .copyFiles([
        {
            from: './assets/images',
            // optional target path, relative to the output dir
            to: 'images/[path][name].[hash:8].[ext]',

            // only copy files matching this pattern
            //pattern: /\.(png|jpg|jpeg)$/
        },
        {
            from: './assets/ckeditor-plugins',
            to: 'ckeditor-plugins/[path][name].[ext]',
        }
    ])

    // Configure JS and CSS minimizers
    .configureJsMinimizerPlugin((options, MinimizerPlugin) => {
        options.minify = MinimizerPlugin.esbuildMinify
    })
    .configureCssMinimizerPlugin((options, MinimizerPlugin) => {
        options.minify = MinimizerPlugin.lightningCssMinify;
    })

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push(['polyfill-corejs3', { method: 'usage-global', version: '3.49' }]);
    // })

    // enables Sass/SCSS support
    .enableSassLoader((options) => {
        options.sassOptions.quietDeps = true;
    })

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()


    .configureMiniCssExtractPlugin(
        (loaderConfig) => {},
        (pluginConfig) => {
            pluginConfig.ignoreOrder = true;
        },
    )
;

if (fs.existsSync(dirname + '/assets/js/admin')) {
    let jsFiles = getFiles(dirname + '/assets/js/admin', [], 'js');
    _.forEach(jsFiles, (fileName) => {
        Encore.addEntry('js/admin/' + fileName, ['./assets/js/admin/' + fileName + '.js']);
    });
}

if (fs.existsSync(dirname + '/assets/scss')) {
    let scssFiles = getFiles(dirname + '/assets/scss', [], 'scss');
    _.forEach(scssFiles, function (fileName) {
        Encore.addStyleEntry('css/' + fileName, ['./assets/scss/' + fileName + '.scss']);
    });
}

export default await Encore.getWebpackConfig();

// Functions
function getFiles(dir, exclude, fileType) {
    let files = fs.readdirSync(dir)
        .filter(function (file) {
            return -1 === exclude.indexOf(file) && !fs.statSync(path.join(dir, file)).isDirectory() && !_.startsWith(file, '_');
        });

    return _.map(files, function (filename) {
        let lastDotPosition = filename.lastIndexOf('.');
        let ext;
        if (lastDotPosition !== -1) {
            ext = filename.substr(lastDotPosition + 1);
            if (ext === fileType) {
                return filename.substr(0, lastDotPosition);
            }
        }
    });
}
