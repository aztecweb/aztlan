<?php
/**
 * Base class
 *
 * @package Aztec
 */

namespace Aztec;

use DI\Container;

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
	 * @param string $function The function name.
	 * @return callable The function to be called.
	 */
	public function callback( $function ) {
		return array( $this->container->get( get_class( $this ) ), $function );
	}
}
