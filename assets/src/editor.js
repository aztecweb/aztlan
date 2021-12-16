/**
 * Editor application
 *
 * Code used to load project Gutenberg editor blocks
 */

/**
 * Internal dependencies
 */

// Import all Scripts from all blocks
import 'glob:./blocks/*/editor.js';
import 'glob:./blocks/*/front.js';

// Import all Sass from all blocks
import './editor/sass/style.scss';
