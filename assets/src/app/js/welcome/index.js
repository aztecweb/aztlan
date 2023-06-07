/**
 * Retrieves the translation of text.
 */
const __ = wp.i18n.__;

export default class Welcome {
	constructor() {
		this.message = __(
			'A professional WordPress environment.',
			'aztlan_assets'
		);
	}

	hello() {
		const p = document.createElement('p');
		const title = document.querySelector('.welcome__title');

		p.innerText = this.message;
		title.parentNode.insertBefore(p, title.nextSibling);
	}
}
