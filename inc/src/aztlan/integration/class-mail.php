<?php
/**
 * Mail class
 *
 * @package Aztec
 */

declare(strict_types = 1);

namespace Aztec\Aztlan\Integration;

use Aztec\Base;

/**
 * Fix mail stuffs
 */
class Mail extends Base {
	/**
	 * Add hooks and filters
	 */
	public function init() : void {
		add_action( 'wp_mail_from', $this->callback( 'set_mail_from' ) );
	}

	/**
	 * Check if from e-mail is valid
	 *
	 * @param  string $from_email From e-mail address.
	 * @return string
	 */
	public function set_mail_from( $from_email ) : string {
		if ( false === filter_var( $from_email, FILTER_VALIDATE_EMAIL ) ) {
			$from_email = 'wordpress@example.com';
		}

		return $from_email;
	}
}
