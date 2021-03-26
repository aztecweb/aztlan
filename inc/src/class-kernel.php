<?php
/**
 * Init class
 *
 * @package Aztec
 */

declare(strict_types = 1);

namespace Aztec;

use DI\Container;

/**
 * Main theme class
 */
class Kernel {

	/**
	 * The dependency injection container
	 *
	 * @var Container
	 */
	protected $container;

	/**
	 * Initialize the container
	 *
	 * @param Container $container The application container.
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Load classes that add or remove hooks
	 */
	public function init() : void {
		$init_classes = array(
			// Aztlan.
			\Aztec\Aztlan\Integration\Mail::class,
			\Aztec\Aztlan\Integration\Livereload::class,

			// Assets.
			\Aztec\Aztlan\Assets\App::class,
			\Aztec\Aztlan\Assets\Editor::class,

			// Languages.
			\Aztec\Setup\Textdomain::class,
		);

		foreach ( $init_classes as $class ) {
			$this->container->get( $class )->init();
		}
	}
}
