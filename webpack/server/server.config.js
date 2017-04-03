module.exports = {
  attachTask: [
    'node_modules/.bin/webpack  --watch',
    'node_modules/.bin/webpack-dev-server'
  ],
  port: 9090,
  watch: "./dist"
};