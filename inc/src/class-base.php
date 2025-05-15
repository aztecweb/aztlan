<?php

declare(strict_types = 1);

namespace Aztec;

use DI\Container;
use Exception;

abstract class Base {

	const VERSION = '0.1';

	protected Container $container;

	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Create a callback from a method
	 *
	 * @throws Exception If $method isn't a callable.
	 */
	public function callback( string $method ): callable {
		$callable = array( $this->container->get( get_class( $this ) ), $method );

		if ( is_callable( $callable ) ) {
			return $callable;
		}

		$message = sprintf( '%s::%s isn\'t a callable method', get_class( $callable[0] ), $callable[1] );
		throw new Exception( esc_html( $message ) );
	}
}
