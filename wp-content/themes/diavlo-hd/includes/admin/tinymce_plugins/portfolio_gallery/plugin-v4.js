/* global tinymce */
tinymce.PluginManager.add('i3d_portfolio_gallery', function( editor, url ) {

	// Register a command so that it can be invoked by using tinyMCE.activeEditor.execCommand( 'I3D_ContentPanelGroup' );
	editor.addCommand( 'i3d_portfoliogallery', function() {
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
			return content.replace(/\[i3d_portfolio_gallery([^\]]*)\]/g, function(a,b){
				//alert(a); 
			//	alert( "returning wtith : " + '[div contenteditable="false" class="i3d_portfolio_gallery mceItem" title="i3d_portfolio_gallery'+tinymce.DOM.encode(b)+'"></div>');
				return '<img src="'+url+'/images/t.gif" class="i3d_portfolio_gallery mceItem" title="i3d_portfolio_gallery'+tinymce.DOM.encode(b)+'" data-mce-resize="false" data-mce-placeholder="1" />';
			});
		

	}

	function restoreShortcodes( content ) {
		function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};

			return content.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function(a,im) {
				var cls = getAttr(im, 'class');
				//alert(getAttr(im, 'title'));
				//alert(im);
				if ( cls.indexOf('i3d_portfolio_gallery') != -1 )
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

			if ( document.getElementById('i3d_portfoliogallery') )
				tinymce.DOM.hide('i3d_portfoliogallery');

			clearTimeout(this.mceTout);
			this.mceTout = 0;
		}	


		function _createButtons() {
			var t = this, ed = tinyMCE.activeEditor, DOM = tinymce.DOM, editButton, delButton;
			
			DOM.remove('i3d_portfoliogallery');

			DOM.add(document.body, 'div', {
				id : 'i3d_portfoliogallery',
				style : 'display:none;'
			});

			editButton = DOM.add('i3d_portfoliogallery', 'img', {
				src : url+'/images/edit2.png',
				id : 'i3d_editportfoliogallery',
				width : '24',
				height : '24',
				title : 'Edit',
				style : 'cursor: pointer; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px ;background: #171613; padding: 5px; margin: 0px 3px;'
			});
			
			tinymce.DOM.bind(editButton, 'mousedown', function(e) {
				var ed = tinymce.activeEditor;
							ed.windowManager.bookmark = ed.selection.getBookmark('simple');
							//this.properties = ed.selection.getNode().title;
							//alert(this.properties);
							//tinyMCE.activeEditor.selection.select(editor.selectedElement);
							//alert(editor.selectedElement);
							
							ed.execCommand("i3d_portfoliogallery");															  
				});

			
			delButton = DOM.add('i3d_portfoliogallery', 'img', {
				src : url+'/images/delete2.png',
				id : 'i3d_delportfoliogallery',
				width : '24',
				height : '24',
				title : 'Remove',
				style : 'cursor: pointer; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; background: #171613; padding: 5px; margin: 50px 3px;'
			});

			tinymce.DOM.bind(delButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor, el = ed.selection.getNode();

				if ( el.nodeName == 'IMG' && ed.dom.hasClass(el, 'i3d_portfolio_gallery') ) {
					ed.dom.remove(el);

					ed.execCommand('mceRepaint');
					_hideButtons();
					return false;
				}														  
				});

		}

	editor.on('mousedown', function(e) {
							var t = this;	
				if ( e.target.nodeName == 'IMG' && editor.dom.hasClass(e.target, 'i3d_portfolio_gallery') ) {
					_showButtons(e.target, 'i3d_portfoliogallery');
					//tinyMCE.activeEditor.selection.select(e.target);
					//alert(tinyMCE.activeEditor.selection.getContent({format : 'text'}));
					tinyMCE.activeEditor.selection.select(e.target);
					t.selectedElement = e.target;
				} else if (e.target.nodeName != 'IMG'  && !editor.dom.hasClass(e.target, 'i3d_portfolio_gallery')) {
					_hideButtons();
				}
			});	


	editor.on( 'init', function( e, url ) {
							
	_createButtons();
	
	});
	
		editor.addButton('i3d_portfolio_gallery', {
			classes: 'widget btn i3d_portfolio_gallery',
			/* image: url + '/images/icon.png', */
			tooltip: 'Add/Modify Portfolio Gallery',
			cmd : 'i3d_portfoliogallery',
			
			
			onclick: onButtonClick
		});
		
	editor.on( 'BeforeSetContent', function( event ) {
			event.content = replaceShortcodes( event.content );
	});

	editor.on( 'GetContent', function( event ) {
			event.content = restoreShortcodes( event.content );
	});		

	editor.on( 'PostProcess', function( event ) {
			event.content = restoreShortcodes( event.content );
	});		
});
