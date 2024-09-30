<?php

declare( strict_types = 1 );

namespace Aztec\Aztlan\Log;

use Psr\Log\LoggerInterface;

class Log implements LoggerInterface {

	private LoggerInterface $logger;

	/**
	 * Instantiate Log with null logger
	 */
	public function __construct( LoggerInterface $logger ) {
		$this->logger = $logger;
	}

	/**
	 * {@inheritDoc}
	 */
	public function emergency( string|\Stringable $message, array $context = array() ): void {
		$this->logger->emergency( $message, $context );
	}

	/**
	 * {@inheritDoc}
	 */
	public function alert( string|\Stringable $message, array $context = array() ): void {
		$this->logger->alert( $message, $context );
	}

	/**
	 * {@inheritDoc}
	 */
	public function critical( string|\Stringable $message, array $context = array() ): void {
		$this->logger->critical( $message, $context );
	}

	/**
	 * {@inheritDoc}
	 */
	public function error( string|\Stringable $message, array $context = array() ): void {
		$this->logger->error( $message, $context );
	}

	/**
	 * {@inheritDoc}
	 */
	public function warning( string|\Stringable $message, array $context = array() ): void {
		$this->logger->warning( $message, $context );
	}

	/**
	 * {@inheritDoc}
	 */
	public function notice( string|\Stringable $message, array $context = array() ): void {
		$this->logger->notice( $message, $context );
	}

	/**
	 * {@inheritDoc}
	 */
	public function info( string|\Stringable $message, array $context = array() ): void {
		$this->logger->info( $message, $context );
	}

	/**
	 * {@inheritDoc}
	 */
	public function debug( string|\Stringable $message, array $context = array() ): void {
		$this->logger->debug( $message, $context );
	}

	/**
	 * {@inheritDoc}
	 */
	public function log( $level, string|\Stringable $message, array $context = array() ): void {
		$this->logger->log( $level, $message, $context );
	}
}
