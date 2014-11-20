/**
 * Plugin Name: Polymer Components
 * Author: Mattia Roccoberton
 * Author URI: http://blocknot.es
 * License: GPL3
 */
function polyDocs( url, group )
{	// admin
	var val = document.getElementById( 'sel_' + group ).value;
	document.getElementById( 'docs_' + group ).href = url + ( ( val != '-' ) ? ( '#' + val ) : '' );
}

window.onload = function() {
	var poly_javascript = document.getElementById( 'poly_javascript' );
	if( poly_javascript != null )
	{
		CodeMirror.fromTextArea( poly_javascript, {
			dragDrop: false,
			indentWithTabs: true,
			lineNumbers: true,
			mode: 'javascript',
			smartIndent: false
		});
	}

	var poly_styles = document.getElementById( 'poly_styles' );
	if( poly_styles != null )
	{
		CodeMirror.fromTextArea( poly_styles, {
			dragDrop: false,
			indentWithTabs: true,
			lineNumbers: true,
			mode: 'css',
			smartIndent: false
		});
	}

	/* var editor_container = document.getElementById( 'wp-content-editor-container' );
	if( editor_container != null )
	{
		var textarea = editor_container.getElementsByTagName( 'textarea' );
		if( textarea.length > 0 )
		{
			CodeMirror.fromTextArea( textarea[0], {
				dragDrop: false,
				indentWithTabs: true,
				lineNumbers: true,
				smartIndent: false
			});
		}
	} */
};
