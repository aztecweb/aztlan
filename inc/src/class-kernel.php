<?php

declare(strict_types = 1);

namespace Aztec;

use Aztec\Aztlan\Log\Log;
use Aztec\Aztlan\Log\Logger_Factory;
use DI\Container;
use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

class Kernel {

	protected Container $container;

	public function __construct( Container $container ) {
		$this->container = $container;

		$this->define_services();
	}

	private function define_services() : void {
		$this->container->set( LoggerInterface::class, $this->create_logger() );
	}

	private function create_logger() : LoggerInterface {
		$log_stream = isset( $_SERVER['LOG_STREAM'] ) ? sanitize_text_field( wp_unslash( $_SERVER['LOG_STREAM'] ) ) : 'php://stdout';
		$log_level  = isset( $_SERVER['LOG_LEVEL'] ) ? sanitize_text_field( wp_unslash( $_SERVER['LOG_LEVEL'] ) ) : 'debug';
		$handler    = new StreamHandler( $log_stream, $log_level );
		$logger     = ( new Logger_Factory() )->create( $handler );
		$log        = new Log( $logger );

		// Show PHP errors on log stream.
		ErrorHandler::register( $logger );

		return $log;
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
