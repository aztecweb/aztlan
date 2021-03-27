<?php

declare(strict_types = 1);

namespace Aztec\Aztlan\Integration;

use Aztec\Base;


class Mail extends Base {

	public function init() : void {
		add_action( 'wp_mail_from', $this->callback( 'set_mail_from' ) );
	}

	public function set_mail_from( string $from_email ) : string {
		if ( false === filter_var( $from_email, FILTER_VALIDATE_EMAIL ) ) {
			$from_email = 'wordpress@example.com';
		}

		return $from_email;
	}
}
