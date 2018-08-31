var webpack = require('webpack');
var path = require('path');

console.log(__dirname);

var BUILD_DIR = path.resolve(__dirname, 'public/build');
var APP_DIR = path.resolve(__dirname, 'web');
var libraryName = 'library';
console.log(BUILD_DIR);

var config = {
  entry: APP_DIR + '/index.jsx',
  watchOptions: {
    poll: true
  },
  output: {
    path: BUILD_DIR,
    filename: 'bundle.js',
    library: libraryName,
    libraryTarget: 'umd',
    umdNamedDefine: true
  },
  module : {
    loaders: [
      {
        test: /(\.jsx|\.js)$/,
        loader: 'babel-loader',
        exclude: /(node_modules|bower_components)/
      },
      {
        test: /\.css$/,
        use: [
          { loader: "style-loader" },
          { loader: "css-loader" }
        ]
      },
    ]
  }
};

module.exports = config;