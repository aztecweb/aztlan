export default class Welcome {
	constructor() {
		this.message = 'Welcome to Aztlan';
	}

	hello() {
		const p = document.createElement( 'p' );
		p.innerText = '...';

		document.querySelector( '.welcome' ).appendChild( p );
	}
}
