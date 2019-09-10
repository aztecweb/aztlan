/**
 * Registers a new block provided a unique name and an object defining its behavior.
 */
const registerBlockType = wp.blocks.registerBlockType;

/**
 * Returns a new element of given type. Element is an abstraction layer atop React.
 */
const el = wp.element.createElement;

/**
 * Retrieves the translation of text.
 */
const __ = wp.i18n.__;

/**
 * Every block starts by registering a new block type definition.
 */
registerBlockType( 'env-theme/aztec-env-test', {

	/**
	 * This is the display title for your block, which can be translated with `i18n` functions.
	 * The block inserter will show this name.
	 */
	title: __( 'Aztec Env Test', 'env-theme_assets' ),

	/**
	 * Blocks are grouped into categories to help users browse and discover them.
	 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
	 */
	category: 'widgets',

	/**
	 * Optional block extended support features.
	 */
	supports: {
		// Removes support for an HTML mode.
		html: false,
	},

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * @param {Object} [props] Properties passed from the editor.
	 * @return {Element}       Element to render.
	 */
	edit( props ) {
		return el(
			'p',
			{ className: props.className },
			__( 'Aztec Env test block', 'env-theme_assets' )
		);
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into `post_content`.
	 *
	 * @return {Element}       Element to render.
	 */
	save() {
		return el(
			'p',
			{},
			__( 'Aztec Env test block', 'env-theme_assets' )
		);
	},
} );
