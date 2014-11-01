/**
 * Plugin Name: Polymer Components
 * Author: Mattia Roccoberton
 * Author URI: http://blocknot.es
 * License: GPL3
 */
function polyDocs( url, group )
{	// admin
	document.getElementById( 'docs_' + group ).href = url + '#' + document.getElementById( 'sel_' + group ).value;
}

window.onload = function() {
	var poly_javascript = document.getElementById( 'poly_javascript' );
	if( poly_javascript != null )
	{
		CodeMirror.fromTextArea( poly_javascript, {
			dragDrop: false,
			indentWithTabs: true,
			lineNumbers: true,
			smartIndent: false
		});
	}
};
