import Webpack from "webpack";
import path from "path";
import validate from "webpack-validator";
import merge from "webpack-merge";
import AssetsPlugin from "assets-webpack-plugin";
import * as actions from "./app/Resources/build/actions.js";


const TARGET = process.env.NODE_ENV || process.env.npm_lifecycle_event;
process.env.BABEL_ENV = TARGET

console.log("BUILDING FOR TARGET:", TARGET);

const PATHS = {
    'public': path.join(__dirname, './web'),
    'build': path.join(__dirname, './web/apps')
}


const common = {
    context: PATHS.public,
    resolve: {
        root: PATHS.public,
        extensions: ['', '.js', '.jsx', '.css'],
        modulesDirectories: ['node_modules', 'web/bundles'],
        alias: {
            jquery: 'jquery/src/jquery'
        }
    },
    entry: {
        // Add your entrypoint here
        'theme': './apps/theme/src/index.js',
        'core': './apps/core/src/index.js',
        'datatables': './apps/datatables/src/index.js',
        'user': './apps/user/src/index.js'
    },
    output: {
        path: PATHS.build,
        filename: '[name]/bundle.js',
        publicPath: '/apps/'
    },
    externals: {
        "translator": "Translator"
    },
    module: {
        loaders: [
            {
                test: /\.jsx?$/,
                loaders: ['babel?cacheDirectory=var/cache/babel-cache'],
                exclude: /node_modules/
            },
            {
                test: /\.json$/,
                loaders: ['json']
            },
            {
                test: /\.(png|jpg|jpeg|gif)?$/,
                loader: 'file'
            },
            {
                test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?(\-[\.a-z0-9]+)?(\?[\.a-z0-9]+)?$/,
                loader: "url-loader?limit=10000&mimetype=application/font-woff"
            },
            {
                test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?(\-[\.a-z0-9]+)?(\?[\.a-z0-9]+)?$/,
                loader: "file-loader"
            },


            {test: require.resolve("moment"), loader: "expose?$!expose?moment"}
        ]
    },
    plugins: [
        new AssetsPlugin({
            filename: 'assets.json'
        }),
        new Webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery"
        }),
        new Webpack.DefinePlugin({
            'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'development'),
            //'require.specified': 'require.resolve'
        })
    ]
};

let config;

switch (TARGET) {
    case 'test':
    case 'test:tdd':
        config = merge(
            common,
            {
                devtool: 'inline-source-map',
                externals: {
                    'react/addons': true,
                    'react/lib/ExecutionEnvironment': true,
                    'react/lib/ReactContext': true
                }
            },
            actions.setupCSS(),
            actions.loadIsparta(PATHS.build)
        );
        break;

    case 'build':
    case 'deploy':
    case 'production':
        config = merge(common,
            {
                devtool: 'source-map',
                plugins: [
                    new Webpack.NoErrorsPlugin(),
                    new Webpack.optimize.UglifyJsPlugin({
                        compress: {
                            warnings: false
                        }
                    })
                ],
                output: {
                    filename: '[name]/bundle.js'
                }
            },
            actions.lintJS(PATHS.build),
            actions.extractCSS(PATHS.style),
            actions.extractCommons(true)
        );
        break;

    default:
        config = merge(common, {
                devtool: 'eval-source-map'
            },
            actions.lintJS(PATHS.build),
            actions.setupCSS(),
            actions.devServer({
                port: process.env.PORT || 3000,
                host: process.env.HOST || "0.0.0.0",
                poll: true
            }),
            actions.enableReactPerformanceTools(),
            actions.extractCommons()
        );
        break;
}

export default validate(config, {
    quiet: true
});
