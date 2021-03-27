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
	 * Create a callback from a function
	 *
	 * @throws Exception If $function isn't a callable.
	 */
	public function callback( string $function ) : callable {
		$callable = array( $this->container->get( get_class( $this ) ), $function );

		if ( is_callable( $callable ) ) {
			return $callable;
		}

		throw new Exception( sprintf( '%s::%s isn\'t a callable function', ...$callable ) );
	}
}
