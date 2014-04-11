(function() {
	tinymce.create('tinymce.plugins.wusm_pullquote', {

	/**
	 *
	 */
	init : function(ed, url) {
		ed.addButton('wusm_set_pullquote', {
			title : 'Set Pullquote Text',
			cmd   : 'wusm_set_pullquote_cmd',
			image : url + '/pullquotebutton2.png'
		});

		ed.addButton('wusm_put_pullquote', {
			title : 'Insert Pullquote',
			cmd   : 'wusm_put_pullquote_cmd',
			image : url + '/pullquotebutton.png'
		});

		ed.addCommand('wusm_set_pullquote_cmd', function() {
			var author = prompt( "Quote author" ),
				credit = prompt( "Author credentials" ),
				shortcode;
			
			if ( author !== null && credit !== null ) {
				shortcode = '[wusm_pullquote_text author="' + author + '" credit="' + credit + '"]'+ed.selection.getContent()+'[/wusm_pullquote_text]';
				ed.execCommand( 'mceInsertContent', 0, shortcode );
			}
		});

		ed.addCommand('wusm_put_pullquote_cmd', function() {
			var shortcode = '[wusm_pullquote]';
			ed.execCommand( 'mceInsertContent', 0, shortcode );
		});
	},

	/**
	 *
	 */
		createControl : function(n, cm) {
			return null;
		},

	/**
	 *
	 */
		getInfo : function() {
			return {
				longname  : 'Add Pullquote button',
				author    : 'Aaron Graham',
				authorurl : '',
				infourl   : '',
				version   : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add( 'wusm_pullquote', tinymce.plugins.wusm_pullquote );
})();