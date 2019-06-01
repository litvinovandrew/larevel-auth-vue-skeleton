let webpack = require('webpack');
let path = require('path');

const VueLoaderPlugin = require('vue-loader/lib/plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {

    mode: (process.env.NODE_ENV === 'production') ? 'production' : 'development',

    entry: {
        app: './resources/js/app.js',
        vendor: ['vue', 'axios']
    },

    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: '[name].js',
        // publicPath: './public'
    },

    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'css-loader'
                ],
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {}
                    // other vue-loader options go here
                }
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
            },

            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]?[hash]'
                }
            },
            {
                test: /\.s[a|c]ss$/,
                loader: 'style!css!sass'
            },
        ]
    },
    resolve: {
        extensions: ['*', '.wasm', '.mjs', '.js', '.jsx', '.json', '.vue'],
        alias: {
            vue$: 'vue/dist/vue.common.js'
        }
    },
    plugins: [
        // make sure to include the plugin!
        new VueLoaderPlugin(),
    ],

    optimization: {
        splitChunks: {
            chunks: 'async',
            minSize: 30000,
            maxSize: 0,
            minChunks: 1,
            maxAsyncRequests: 5,
            maxInitialRequests: 3,
            automaticNameDelimiter: '~',
            name: true,
            cacheGroups: {
                vendors: {
                    test: /[\\/]node_modules[\\/]/,
                    priority: -10
                },
                default: {
                    minChunks: 2,
                    priority: -20,
                    reuseExistingChunk: true
                }
            }
        }
    }

}

if (process.env.NODE_ENV === 'production') {
    module.exports.optimization.minimizer = [
        new UglifyJsPlugin()
    ];
}

