<?php
/*
Plugin Name:  Register Theme Directory
Description:  Register theme directory from application environment
Version:      1.0.0
Author:       Aztec Online Solutions
Author URI:   https://aztecweb.net/
License:      GPLv2
*/

$aztec_project_themes_dir = getenv( 'PROJECT_THEMES_DIR' );

// Ignora carregamento caso variável não for definida
if( empty( $aztec_project_themes_dir ) ) {
    return;
}

$registered = register_theme_directory( $aztec_project_themes_dir );

// Lança um erro caso o diretório não existe
if( ! $registered ) {
    trigger_error( "Directory {$aztec_project_themes_dir} registered in PROJECT_THEMES_DIR environment variable does not exist.", E_USER_WARNING );
    return;
}

/**
 * Define URL do tema para quando é um tema pertencente ao ambiente
 *
 * @param string $theme_root_uri URI definida. Se for do ambiente, será o
 *                               caminho do diretório definido em
 *                               PROJECT_THEMES_DIR.
 * @param string $site_url URL do site.
 * @param string $stylesheet_or_template Slug do tema.
 * @return string A URL ajustada caso seja pertencente ao ambiente.
 */
function aztec_project_theme_root_uri( $theme_root_uri, $site_url, $stylesheet_or_template ) {
    if( getenv( 'PROJECT_THEMES_DIR' ) !== $theme_root_uri ) {
        return $theme_root_uri;
    }

    return $site_url . '/themes';
}
add_filter( 'theme_root_uri', 'aztec_project_theme_root_uri', 10, 3 );
