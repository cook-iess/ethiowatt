/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["src/**/*.{html,js,php}"],
  theme: {
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      white: '#ffffff',
      'BrownLight': '#E5D3B3',
      'BrownDark': '#664229',
      'BrownDark2': '#9A7B4F',
      'BrownDark3': '#E0CDA9',
      'red': '#FF0000',
      'metal': '#565584',
      'tahiti': '#3ab7bf',
      'silver': '#ecebff',
      'bubble-gum': '#ff77e9',
      'bermuda': '#78dcca',
    },
    fontFamily: {
      TextFont: ['Libre Baskerville'],
      TitleFont: ['DM Serif Display']
    },
    extend: {},
  },
  plugins: [],
}
