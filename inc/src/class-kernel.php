<?php

declare(strict_types = 1);

namespace Aztec;

use DI\Container;

class Kernel {

	protected Container $container;

	public function __construct( Container $container ) {
		$this->container = $container;
	}

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
