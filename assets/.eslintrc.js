module.exports = {
	extends: [ 'plugin:@wordpress/eslint-plugin/recommended' ],
	rules: {
		'import/no-unresolved': [
			'error',
			{
				ignore: [ '^glob:' ],
			},
		],
	},
	globals: {
		wp: true,
		window: true,
		history: true,
		document: true,
		location: true,
		XMLHttpRequest: true,
	},
};
