<?php
/**
 * Created on 26.09.2009
 *
 * Copyright (C) 2009	Kirill Krasnov
 * ICQ					82427351
 * JID					krak@jabber.ru
 * Skype				kirillkr
 * Homepage			http://www.kraeg.ru
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

/**
 *  requires MantisPlugin.class.php
 */

require_once( config_get( 'class_path' ) . 'MantisPlugin.class.php' );

class SearchPlugin extends MantisPlugin {

	/**
	 *  A method that populates the plugin information and minimum requirements.
	 */
	function register( ) {
		$this->name = plugin_lang_get( 'title' );
		$this->description = plugin_lang_get( 'description' );
		//$this->page = 'config';

		$this->version = '0.0.2';
		$this->requires = array(
			'MantisCore' => '1.2.0rc2',
		);

		$this->author = 'Krasnov Kirill';
		$this->contact = 'krasnovforum@gmail.com';
		$this->url = 'http://www.kraeg.ru';
	}

	/**
	 * Install plugin function.
	 */
	function install() {
		return true;
	}

	/*
	 * Default plugin configuration.
	 */
	function hooks( ) {
		$t_hooks = array(
			'EVENT_MENU_MAIN'  => 'print_menu_search',
		);
		return array_merge( parent::hooks(), $t_hooks );
	}

	function print_menu_search( ) {
		$t_links = array();
		$t_page = plugin_page( 'index' );
		$t_lang = plugin_lang_get( 'search_link' );
		$t_links[] = "<a href=\"$t_page\">$t_lang</a>";
		return $t_links;
	}

}
?>