<?php
/**
 * Base class
 *
 * @package Aztec
 */

declare(strict_types = 1);

namespace Aztec;

use DI\Container;
use Exception;

/**
 * Base class for manipulate hooks using dependency injection
 */
abstract class Base {
	/**
	 * Current version
	 *
	 * @var string
	 */
	const VERSION = '0.1';

	/**
	 * The dependency injection container
	 *
	 * @var Container
	 */
	protected $container;

	/**
	 * Setting the container
	 *
	 * @param Container $container The container.
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Get class function inner the container.
	 *
	 * @throws Exception If $function isn't a callable.
	 * @param string $function The function name.
	 * @return callable The function to be called.
	 */
	public function callback( $function ) : callable {
		$callable = array( $this->container->get( get_class( $this ) ), $function );

		if ( is_callable( $callable ) ) {
			return $callable;
		}

		throw new Exception( sprintf( '%s::%s isn\'t a callable function', ...$callable ) );
	}
}
