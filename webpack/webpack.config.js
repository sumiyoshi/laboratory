const webpack = require("webpack");
const WebpackBuildNotifierPlugin = require('webpack-build-notifier');
const HtmlWebPackPlugin = require('html-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const MODE = process.env.NODE_ENV;
const enabledSourceMap = (MODE === 'development');

let dir = __dirname;
let output_path = (MODE === 'development') ? `${dir}/htdocs-dev/` : `${dir}/htdocs/`;

module.exports = {
  mode: MODE,
  cache: false,
  devServer: {
    contentBase: 'htdocs-dev'
  },
  entry: {
    bundle: `${dir}/src/entry.js`
  },
  output: {
    path: output_path,
    filename: "js/[name].min.js"
  },
  plugins: [
    new WebpackBuildNotifierPlugin({
      title: "Webpack Build"
    }),
    new CopyWebpackPlugin([
      {from: `${dir}/node_modules/jquery/dist/jquery.min.js`, to: `${output_path}/vendor/js/jquery.min.js`},
    ]),
    new HtmlWebPackPlugin({template: "./src/html/index.html", filename: "./index.html"})
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
        test: /\.html$/,
        use: [
          {
            loader: "html-loader"
          }
        ]
      },
      {
        test: /\.(jpg|png|gif)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[path][name].[ext]',
              outputPath : function(path){
                return path.replace('src/', '');
              }
            }
          }
        ]
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel-loader',
        query: {
          presets: [
            ['env', {'modules': false}]
          ]
        },
      },
      {
        test: /\.scss/,
        use: [
          'style-loader',
          {
            loader: 'css-loader',
            options: {
              url: false,// url()メソッドの取り込みを禁止する
              sourceMap: enabledSourceMap,
              // 0 => no loaders (default);
              // 1 => postcss-loader;
              // 2 => postcss-loader, sass-loader
              importLoaders: 2
            }
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: enabledSourceMap
            }
          }
        ]
      }
    ]
  }
};