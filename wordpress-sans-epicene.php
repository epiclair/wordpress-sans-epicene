<?php
/*
Plugin Name: WordPress en français sans épicène
Version: 1
*/

if (!function_exists("add_filter")) {
	exit();
}


function wse__fichiers_langues($fichiers_langues) {
	
	$fichiers_langues = [
		"admin" => [
			"nom_fichier" => "admin-fr_FR",
		],
		"admin-network" => [
			"nom_fichier" => "admin-network-fr_FR",
		],
		"base" => [
			"nom_fichier" => "fr_FR",
		],
	];
	
	return $fichiers_langues;
	
}

add_filter("wse__fichiers_langues", "wse__fichiers_langues", 10, 1);



function wse__load_textdomain($domain, $mofile) {
	
	
	if (	isset($GLOBALS["wse__corrections_chargees"])
		||	("default" !== $domain)
		||	("fr_FR" !== determine_locale()) // la langue actuelle n'est pas le français
	) {
		return;
	}
	
	
	$GLOBALS["wse__corrections_chargees"] = TRUE;
	
	
	$fichiers_langues = apply_filters("wse__fichiers_langues", NULL);
	
	$repertoire = __DIR__ . "/langues";
	
	
	if (isset($fichiers_langues["base"])) {
		load_textdomain( 'default', "$repertoire/{$fichiers_langues["base"]["nom_fichier"]}.mo" );
	}
	
	if ( isset($fichiers_langues["admin"]) && (is_admin() || wp_installing() || ( defined( 'WP_REPAIRING' ) && WP_REPAIRING ))) {
		load_textdomain( 'default', "$repertoire/{$fichiers_langues["admin"]["nom_fichier"]}.mo" );
	}
	
	if ( isset($fichiers_langues["admin-network"]) && (is_network_admin() || ( defined( 'WP_INSTALLING_NETWORK' ) && WP_INSTALLING_NETWORK )) ) {
		load_textdomain( 'default', "$repertoire/{$fichiers_langues["admin-network"]["nom_fichier"]}.mo" );
	}
	
}

add_action("load_textdomain", "wse__load_textdomain", 10, 2);




