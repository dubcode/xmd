// Set flag to include Preflight conditionally based on the build target.
const includePreflight = ('editor' === process.env._TW_TARGET) ? false : true;
const colors = require('./custom/theme-config/colors.js');

module.exports = {
	presets: [
		// Manage Tailwind Typography's configuration in a separate file.
		require('./tailwind-typography.config.js'),
	],
	content: [
		// Ensure changes to PHP files and `theme.json` trigger a rebuild.
		'./theme/**/*.php',
		'./theme/theme.json',
		'./node_modules/tw-elements/dist/js/**/*.js',
	],
	theme: {
		container: {
			padding: '2rem',
		},
		fontFamily: {
			'sans': ['Source Sans Pro', 'Arial', 'Helvetica', 'sans-serif']
		},
		screens: {
			'sm': '640px',
			'md': '768px',
			'ml': '901px',
			'lg': '1024px',
			'xl': '1280px',
			'2xl': '1536px',
		},
		// Extend the default Tailwind theme.
		extend: {
			colors: {
				...colors,
				// Customise the theme colours here without having to change template files
				theme: {
					'text-body': colors.grey[700],
					'text-heading': colors.grey[900],
					'section-topbar': colors.grey[800],
					'section-header': colors.grey[900],
					'section-footer': colors.grey[900],
					'section-copyright': colors.grey[800],
				},
			},
			fontFamily: {
				'sans': ['Source Sans Pro', 'Arial', 'Helvetica', 'sans-serif']
			},
			maxWidth: {
				'md-lg': '49.25rem'
			},
		}
	},
	corePlugins: {
		// Disable Preflight base styles in CSS targeting the editor.
		preflight: includePreflight,
	},
	plugins: [
		// Add Tailwind Typography.
		require('@tailwindcss/typography'),

		// Extract colors and widths from `theme.json`.
		require('@_tw/themejson')(require('../theme/theme.json')),

		require('tw-elements/dist/plugin'),

		// Uncomment below to add additional first-party Tailwind plugins.
		// require( '@tailwindcss/aspect-ratio' ),
		// require( '@tailwindcss/forms' ),
		// require( '@tailwindcss/line-clamp' ),
	],
};
