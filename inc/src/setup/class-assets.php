<?php
/**
 * Gerencia os arquivos estáticos do tema.
 *
 * @package Aztec
 */

namespace Aztec\Setup;

use Aztec\Base;
use DI\Container;

/**
 * Manipula os estilos e scripts da aplicação.
 */
class Assets extends Base {
	/**
	 * Versão atual dos assets.
	 *
	 * @var string
	 */
	const VERSION = '0.1';

	/**
	 * Init.
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_styles' ), 1 );
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_script' ) );
	}

	/**
	 * Retorna a URL do diretório assets
	 *
	 * @param  string $path Caminho do arquivo.
	 * @return string
	 */
	private function assets_uri( $path ) {
		return getenv( 'ASSETS_URL' ) . '/' . trim( $path, '/' );
	}

	/**
	 * Carrega o CSS da aplicação.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'aztec-env', $this->assets_uri( 'app.css' ), [], self::VERSION );
	}

	/**
	 * Carregar o JS da aplicação.
	 */
	public function enqueue_script() {
		wp_enqueue_script( 'aztec-env-vendor', $this->assets_uri( 'vendor.js' ), [ 'jquery' ], self::VERSION, true );
		wp_enqueue_script( 'aztec-env-app', $this->assets_uri( 'app.js' ), [], self::VERSION, true );
		wp_localize_script( 'aztec-env-app', 'aztec_env', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
}
