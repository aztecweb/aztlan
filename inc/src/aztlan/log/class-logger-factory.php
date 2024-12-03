<?php

declare( strict_types = 1 );

namespace Aztec\Aztlan\Log;

use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Bypass log o keep the classes code more fluid
 */
class Logger_Factory {

	private const LOG_CHANNEL = 'aztlan';

	/**
	 * Create a logger with one handler or a array of handlers
	 *
	 * @param HandlerInterface|list<HandlerInterface> $handler
	 * @return LoggerInterface
	 */
	public function create( $handler ): LoggerInterface {
		if ( ! is_array( $handler ) ) {
			$handler = array( $handler );
		}

		return new Logger( self::LOG_CHANNEL, $handler );
	}
}
