const webpack = require("webpack");
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const WebpackBuildNotifierPlugin = require('webpack-build-notifier');

let dir = __dirname;

module.exports = [
  {
    cache: false,
    entry: {
      bundle: `${dir}/src/js/app.js`,
      reload: `${dir}/src/watch/reload.js`
    },
    output: {
      path: `${dir}/dist/`,
      publicPath: `${dir}/dist/`,
      filename: "js/[name].min.js"
    },
    devServer: {
      contentBase: `${dir}/dist/`
    },
    plugins: [
      new webpack.DefinePlugin({
        'process.env': {
          NODE_ENV: '"production"'
        }
      }),
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
        `${dir}/src/js`,
        `${dir}/src/styles`,
        "node_modules"
      ],
      alias: {
        'vue$': 'vue/dist/vue.common.js'
      }
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          loader: 'babel-loader',
          query: {
            presets: ['stage-2']
          }
        },
        {
          test: /\.scss$/,
          use: ExtractTextPlugin.extract({
            fallback: "style-loader",
            use: "css-loader!sass-loader"
          })
        }
      ]
    }
  }
];