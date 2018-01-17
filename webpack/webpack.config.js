const webpack = require("webpack");
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const WebpackBuildNotifierPlugin = require('webpack-build-notifier');

let dir = __dirname;
let output_path = `${dir}/public/`;

module.exports = {
    cache: false,
    devServer: {
        contentBase: 'public'
    },
    entry: {
        bundle: `${dir}/src/entry.js`
    },
    output: {
        path: output_path,
        filename: "js/[name].min.js"
    },
    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false
            }
        }),
        new WebpackBuildNotifierPlugin({
            title: "Webpack Build"
        }),
        new ExtractTextPlugin("css/[name].min.css")
    ],
    resolve: {
        modules: [
            `${dir}/src/scripts`,
            `${dir}/src/styles`,
            "node_modules"
        ]
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                query: {
                    presets: [
                        ['env', {'modules': false}]
                    ]
                }
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: "css-loader?minimize!sass-loader"
                })
            }
        ]
    }
};