/**
 * Plugin Name: Polymer
 * Author: Mattia Roccoberton
 * Author URI: http://blocknot.es
 * License: GPL3
 */
function polyDocs( url, group )
{	// admin
	document.getElementById( 'docs_' + group ).href = url + '#' + document.getElementById( 'sel_' + group ).value;
}
