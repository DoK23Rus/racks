const { defineConfig } = require('@vue/cli-service');
module.exports = defineConfig({
  transpileDependencies: true,
  configureWebpack: {
    watchOptions: {
      aggregateTimeout: 200,
      poll: 100,
      ignored: ['node_modules']
    }
  }
});
