/**asd
 * Registers a new block provided a unique name and an object defining its behavior.
 */
const registerBlockType = wp.blocks.registerBlockType;

/**
 * Retrieves the translation of text.
 */
const __ = wp.i18n.__;

/**
 * The block content to be rendered on editor and frontend
 */
const blockContent = <p>{ __( 'Aztlan demo block.', 'aztlan_assets' ) }</p>;

/**
 * Every block starts by registering a new block type definition.
 */
registerBlockType( 'aztlan/demo', {
	/**
	 * This is the display title for your block, which can be translated with `i18n` functions.
	 * The block inserter will show this name.
	 */
	title: __( 'Aztlan Demo', 'aztlan_assets' ),

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
	 * @return {Element}       Element to render.
	 */
	edit: () => blockContent,

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into `post_content`.
	 *
	 * @return {Element}       Element to render.
	 */
	save: () => blockContent,
} );
