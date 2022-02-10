/* global tinymce */
tinymce.PluginManager.add('i3d_cta', function( editor, url ) {

	// Register a command so that it can be invoked by using tinyMCE.activeEditor.execCommand( 'I3D_ContentPanelGroup' );
	editor.addCommand( 'I3D_CallToAction', function() {
		tinymce.activeEditor.windowManager.open({
		url : url + '/dialog.php?url='+ encodeURI(url) + '&properties='+encodeURI(tinyMCE.activeEditor.selection.getNode().title + '&id=' + tinyMCE.activeEditor.id),
	   width: 640,
	   height: 480
	}, {
	   custom_param: 1
	});
													 

	});

	
	function onButtonClick() {
	}

	
	function replaceShortcodes( content ) {
		
			//tinyMCE.activeEditor.dom.loadCSS(url + '/styles.css');
						editor.dom.loadCSS(url + '/styles.css');

			//load the styles for the page itself (needed for the buttons that appear on click)
			tinymce.DOM.loadCSS(url + '/styles.css');
			
			//replace short tag with image
			return content.replace(/\[i3d_cta([^\]]*)\]/g, function(a,b){
				return '<img src="'+url+'/images/t.gif" class="i3d_cta mceItem" title="i3d_cpg'+tinymce.DOM.encode(b)+'" />';
			});
		

	}

	function restoreShortcodes( content ) {
		function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};

			return content.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function(a,im) {
				var cls = getAttr(im, 'class');

				if ( cls.indexOf('i3d_cta') != -1 )
					return '<p>['+tinymce.trim(getAttr(im, 'title'))+']</p>';

				return a;
			});
	}
		function _showButtons (n, id) {
			var t = this;
			var ed = editor, p1, p2, vp, DOM = tinymce.DOM, X, Y;

			vp = ed.dom.getViewPort(ed.getWin());
			p1 = DOM.getPos(ed.getContentAreaContainer());
			p2 = ed.dom.getPos(n);

			X = Math.max(p2.x - vp.x, 0) + p1.x;
			Y = Math.max(p2.y - vp.y, 0) + p1.y;

			DOM.setStyles(id, {
				'top' : Y+5+'px',
				'left' : X+5+'px',
				'display' : 'block'
			});

			if ( this.mceTout )
				clearTimeout(this.mceTout);

			this.mceTout = setTimeout( function() { _hideButtons(); }, 5000 );
		}

		function _hideButtons () {
			var t = this;
			
			if ( !this.mceTout )
				return;

			if ( document.getElementById('i3d_calltoaction') )
				tinymce.DOM.hide('i3d_calltoaction');

			clearTimeout(this.mceTout);
			this.mceTout = 0;
		}	


		function _createButtons() {
			var t = this, ed = tinyMCE.activeEditor, DOM = tinymce.DOM, editButton, delButton;
			
			DOM.remove('i3d_calltoaction');

			DOM.add(document.body, 'div', {
				id : 'i3d_calltoaction',
				style : 'display:none;'
			});

			editButton = DOM.add('i3d_calltoaction', 'img', {
				src : url+'/images/edit2.png',
				id : 'i3d_editcta',
				width : '24',
				height : '24',
				title : 'Edit',
				style : 'border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px ;background: #171613; padding: 5px; margin: 0px 3px;'
			});
			
			tinymce.DOM.bind(editButton, 'mousedown', function(e) {
				var ed = tinymce.activeEditor;
							ed.windowManager.bookmark = ed.selection.getBookmark('simple');
							//this.properties = ed.selection.getNode().title;
							//alert(this.properties);
							ed.execCommand("I3D_CallToAction");															  
				});

			
			delButton = DOM.add('i3d_calltoaction', 'img', {
				src : url+'/images/delete2.png',
				id : 'i3d_delcta',
				width : '24',
				height : '24',
				title : 'Remove',
				style : 'border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px ;background: #171613; padding: 5px; margin: 0px 3px;'
			});

			tinymce.DOM.bind(delButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor, el = ed.selection.getNode();

				if ( el.nodeName == 'IMG' && ed.dom.hasClass(el, 'i3d_cta') ) {
					ed.dom.remove(el);

					ed.execCommand('mceRepaint');
					_hideButtons();
					return false;
				}														  
				});

		}

	editor.on('mousedown', function(e) {
							var t = this;	
				if ( e.target.nodeName == 'IMG' && editor.dom.hasClass(e.target, 'i3d_cta') ) {
					_showButtons(e.target, 'i3d_calltoaction');
				} else if (e.target.nodeName != 'IMG') {
					_hideButtons();
				}
			});	


	editor.on( 'init', function( e, url ) {
							
	_createButtons();
	
	});
	
		editor.addButton('i3d_cta', {
			classes: 'widget btn i3d_cta',
/*			image: url + '/images/icon.png', */
			tooltip: 'Add/Modify Call To Action',
			cmd : 'I3D_CallToAction',
			
			
			onclick: onButtonClick
		});
		
	editor.on( 'BeforeSetContent', function( event ) {
			event.content = replaceShortcodes( event.content );
	});

	editor.on( 'PostProcess', function( event ) {
			event.content = restoreShortcodes( event.content );
	});		
});
