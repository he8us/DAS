import webpack from 'webpack'
import ExtractTextPlugin from 'extract-text-webpack-plugin'
import postcssImport from 'postcss-import'
import autoprefixer from 'autoprefixer'
import postcssNested from 'postcss-nested'
import postcssSimpleVars from 'postcss-simple-vars'
import cssnano from 'cssnano'

export const lintJS = function (path) {
    return {
        module: {
            preLoaders: [
                {
                    test: /\.jsx?$/,
                    loaders: ['eslint'],
                    include: path
                }
            ]
        }
    }
}

export const extractCommons = function (deploy = false) {
    let name = "shared.js"
/*
    if(deploy){
        name = "shared.[hash].js";
    }
*/
    return {
        plugins: [
            new webpack.optimize.CommonsChunkPlugin("commons", name)
        ]
    }


}

export const loadIsparta = function (include) {
    return {
        module: {
            preLoaders: [
                {
                    test: /\.jsx?$/,
                    loaders: ['isparta-instrumenter'],
                    include: include
                }
            ]
        }
    };
}

export const enableReactPerformanceTools = function () {
    /*
    return {
        module: {
            loaders: [
                {
                    test: require.resolve('react'),
                    loader: 'expose?React'
                },
                {
                    test: /\.jsx?$/,
                    exclude: /node_modules/,
                    loader: 'react-hot'
                }
            ]
        }
    };
    */
}

export const devServer = function (options) {
    const ret = {
        devServer: {
            // Enable history API fallback so HTML5 History API based
            // routing works. This is a good default that will come
            // in handy in more complicated setups.
            historyApiFallback: true,

            // Unlike the cli flag, this doesn't set
            // HotModuleReplacementPlugin!
            hot: true,
            //inline: true,

            // Display only errors to reduce the amount of output.
            //stats: 'errors-only',

            // Parse host and port from env to allow customization.
            //
            // If you use Vagrant or Cloud9, set
            // host: options.host || '0.0.0.0';
            //
            // 0.0.0.0 is available to all network devices
            // unlike default `localhost`.
            host: options.host, // Defaults to `localhost`
            port: options.port // Defaults to 8080
        },
        plugins: [
            // Enable multi-pass compilation for enhanced performance
            // in larger projects. Good default.
            new webpack.HotModuleReplacementPlugin({
                multiStep: true
            })
        ]
    };

    if (options.poll) {
        ret.watchOptions = {
            // Delay the rebuild after the first change
            aggregateTimeout: 1000,
            // Poll using interval (in ms, accepts boolean too)
            poll: 1000
        };
    }

    return ret;
}

export const setupCSS = function () {
    return {
        module: {
            loaders: [
                {
                    test:    /\.less$/,
                    loaders: ['style', 'css', 'postcss', 'less']
                },
                {
                    test: /\.css$/,
                    loaders: ['style', 'css', 'postcss']
                }
            ]
        },
        postcss: function(webpack){
            return [
                postcssImport({
                    addDependencyTo: webpack
                }),
                autoprefixer,
                postcssNested,
                postcssSimpleVars,
                cssnano
            ]
        }
    };
}


export const setFreeVariable = function (key, value) {
    const env = {};
    env[key] = JSON.stringify(value);

    return {
        plugins: [
            new webpack.DefinePlugin(env)
        ]
    };
}

export const extractBundle = function (options) {
    const entry = {};
    entry[options.name] = options.entries;

    return {
        // Define an entry point needed for splitting.
        entry: entry,
        plugins: [
            // Extract bundle and manifest files. Manifest is
            // needed for reliable caching.
            new webpack.optimize.CommonsChunkPlugin({
                names: [options.name, 'manifest'],

                // options.name modules only
                minChunks: Infinity
            })
        ]
    };
}

export const extractCSS = function () {
    return {
        module: {
            loaders: [
                // Extract CSS during build
                {
                    test:    /\.less$/,
                    loader: ExtractTextPlugin.extract('style', ['css', 'postcss', 'less'])
                },
                {
                    test: /\.css$/,
                    loader: ExtractTextPlugin.extract('style', ['css', 'postcss'])
                }
            ]
        },
        plugins: [
            // Output extracted CSS to a file
            new ExtractTextPlugin('[name]/bundle.css')
        ],
        postcss: function(webpack) {
            return [
                postcssImport({
                    addDependencyTo: webpack
                }),
                autoprefixer,
                postcssNested,
                postcssSimpleVars,
                cssnano
            ]
        }
    };
}
