const path = require( 'path' );
const TerserPlugin = require( 'terser-webpack-plugin' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const CssMinimizerPlugin = require( 'css-minimizer-webpack-plugin' );

module.exports = ( env ) => {
	return {
		mode: env.production ? 'production' : 'development',
		entry: {
			app: './src/app.js',
			editor: './src/editor.js',
		},
		output: {
			filename: '[name].js',
			path: path.resolve( __dirname, 'dist' ),
		},
		devtool: 'source-map',
		module: {
			rules: [
				{
					test: /\.(js|jsx)$/,
					exclude: /(node_modules)/,
					use: [ 'babel-loader' ],
				},
				{
					test: /\.s[ca]ss$/,
					use: [
						MiniCssExtractPlugin.loader,
						{
							loader: 'css-loader',
							options: {
								sourceMap: true,
							},
						},
						{
							loader: 'sass-loader',
							options: {
								sourceMap: true,
							},
						},
					],
				},
				{
					test: /\.css$/,
					use: [
						{
							loader: 'style-loader',
							options: {
								sourceMap: true,
							},
						},
						{
							loader: 'css-loader',
							options: {
								sourceMap: true,
							},
						},
					],
				},
				{
					test: /\.(png|jp(e*)g|gif)$/,
					use: [ 'file-loader' ],
				},
				{
					test: /\.(woff|woff2|svg|eot|ttf|otf)$/,
					use: [ 'file-loader' ],
				},
			],
		},
		plugins: [
			new MiniCssExtractPlugin( {
				filename: '[name].css',
			} ),
		],
		optimization: {
			splitChunks: {
				cacheGroups: {
					commons: {
						test: /[\\/]node_modules[\\/]/,
						name: 'vendor',
						chunks: 'all',
						filename: 'vendor.js',
					},
				},
			},
			minimizer: [ new TerserPlugin(), new CssMinimizerPlugin() ],
		},
		externals: {
			jquery: 'jQuery',
		},
	};
};
