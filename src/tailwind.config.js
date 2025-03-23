/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './templates/**/*.html.twig',
    './assets/**/*.js',
    './src/**/*.php'
  ],
  safelist: [
    'bg-gradient-to-r',
    'from-blue-600',
    'to-blue-800',
    'bg-clip-text',
    'text-transparent',
    'lg:text-2xl',
    {
      pattern: /^(sm|md|lg|xl|2xl)\:.+/,
    }
  ],
  theme: {
    extend: {}
  },
  corePlugins: {
    preflight: true,
    backgroundClip: true,
  },
  plugins: []
};
