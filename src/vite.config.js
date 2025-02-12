import { defineConfig } from 'vite';
import symfonyPlugin from 'vite-plugin-symfony';

export default defineConfig({
  plugins: [
    symfonyPlugin({
      sass: false
    })
  ],
  css: {
    postcss: './postcss.config.cjs'
  },
  build: {
    manifest: true,
    rollupOptions: {
      input: {
        app: './assets/app.js'
      }
    }
  }
});
