<?php
/**
 * Mail SMTP setup.
 *
 * @package Aztec
 */

namespace Aztec\Setup;

use Aztec\Base;

/**
 * Mail SMTP Setup
 */
class Mail_SMTP extends Base {

	/**
	 * Add hooks
	 */
	public function init() {
		add_filter( 'phpmailer_init', $this->callback( 'phpmailer_setup' ) );
	}

	/**
	 * Setup phpmailer configurations
	 *
	 * @param PHPMailer $phpmailer The PHPMailer instance (passed by reference).
	 */
	public function phpmailer_setup( $phpmailer ) {

		if ( getenv( 'MAILER' ) !== false ) {
			$phpmailer->Mailer = getenv( 'MAILER' ); // phpcs:disable
		}
		if ( getenv( 'MAIL_FROM_NAME' ) !== false ) {
			$phpmailer->FromName = getenv( 'MAIL_FROM_NAME' ); // phpcs:disable
		}
		if ( getenv( 'MAIL_FROM' ) !== false ) {
			$phpmailer->From = getenv( 'MAIL_FROM' ); // phpcs:disable
		}
		if ( getenv( 'SMTP_SECURE' ) !== false ) {
			$phpmailer->SMTPSecure = getenv( 'SMTP_SECURE' ); // phpcs:disable
		}
		if ( getenv( 'SMTP_HOST' ) !== false ) {
			$phpmailer->Host = getenv( 'SMTP_HOST' ); // phpcs:disable
		}
		if ( getenv( 'SMTP_PORT' ) !== false ) {
			$phpmailer->Port = getenv( 'SMTP_PORT' ); // phpcs:disable
		}
		if ( getenv( 'SMTP_USER' ) !== false ) {
			$phpmailer->Username = getenv( 'SMTP_USER' ); // phpcs:disable
		} 
		if ( getenv( 'SMTP_PASSWORD' ) !== false ) {
			$phpmailer->Password = getenv( 'SMTP_PASSWORD' ); // phpcs:disable
		} 

		if ( false !== $phpmailer->Username && false !== $phpmailer->Password ) {
            $phpmailer->SMTPAuth   = true; // phpcs:disable
		}
	}
}