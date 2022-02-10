(function() {
	// Load plugin specific language pack
	//tinymce.PluginManager.requireLangPack('I3DContentPanelGroup');
	
	tinymce.create('tinymce.plugins.I3DContentPanelGroup', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			var t = this;
			t.url = url;
			var properties = 'false';
			var mceTout = 0;
			
			t._createButtons();
						
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceContactForm');
			ed.addCommand('mceContentPanelGroup', function() {			
				ed.windowManager.open({
					file : url + '/dialog.php?url='+ encodeURI(url) + '&properties='+encodeURI(tinyMCE.activeEditor.selection.getNode().title + '&id=' + tinyMCE.activeEditor.id),
					width : 620,
					height : 420,
					inline : 1
				}, {
					plugin_url : url // Plugin absolute URL
				});
			});

			// Register button
			ed.addButton('i3d_cpg', {
				title : 'Content Panel Group',
				cmd : 'mceContentPanelGroup',
				image : url + '/images/icon.png'
			});

			ed.onInit.add(function(ed) {
				tinymce.dom.Event.add(ed.getWin(), 'scroll', function(e) {
					t._hideButtons();
				});
				tinymce.dom.Event.add(ed.getBody(), 'dragstart', function(e) {
					t._hideButtons();
				});
			});
		
			
			ed.onSaveContent.add(function(ed, o) {
				t._hideButtons();
			});
				
			ed.onMouseDown.add(function(ed, e) {
				if ( e.target.nodeName == 'IMG' && ed.dom.hasClass(e.target, 'i3d_cpg') ) {
					t._showButtons(e.target, 'i3d_contentpanelgroup');
				} else if (e.target.nodeName != 'IMG') {
					t._hideButtons();
				}
			});
			
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._do_contact(o.content,t.url);
			});

			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = t._get_contact(o.content);
			});
			
			ed.onBeforeExecCommand.add(function(ed, cmd, ui, val) {
				t._hideButtons();
			});				
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},


		_do_contact : function(co,url) {
			//load the styles for the editor window
			tinyMCE.activeEditor.dom.loadCSS(url + '/styles.css');
			
			//load the styles for the page itself (needed for the buttons that appear on click)
			tinymce.DOM.loadCSS(url + '/styles.css');
			
			//replace short tag with image
			return co.replace(/\[i3d_cpg([^\]]*)\]/g, function(a,b){
				return '<img src="'+url+'/images/t.gif" class="i3d_cpg mceItem" title="i3d_cpg'+tinymce.DOM.encode(b)+'" />';
			});
		},

		_get_contact : function(co) {

			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};

			return co.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function(a,im) {
				var cls = getAttr(im, 'class');

				if ( cls.indexOf('i3d_cpg') != -1 )
					return '<p>['+tinymce.trim(getAttr(im, 'title'))+']</p>';

				return a;
			});
		},
		
		_showButtons : function(n, id) {
			var t = this;
			var ed = tinyMCE.activeEditor, p1, p2, vp, DOM = tinymce.DOM, X, Y;

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

			this.mceTout = setTimeout( function(){t._hideButtons();}, 5000 );
		},		

		_hideButtons : function() {
			var t = this;
			
			if ( !this.mceTout )
				return;

			if ( document.getElementById('i3d_contentpanelgroup') )
				tinymce.DOM.hide('i3d_contentpanelgroup');

			clearTimeout(this.mceTout);
			this.mceTout = 0;
		},		

		_createButtons : function() {
			var t = this, ed = tinyMCE.activeEditor, DOM = tinymce.DOM, editButton, delButton;
			
			DOM.remove('i3d_contentpanelgroup');

			DOM.add(document.body, 'div', {
				id : 'i3d_contentpanelgroup',
				style : 'display:none;'
			});

			editButton = DOM.add('i3d_contentpanelgroup', 'img', {
				src : t.url+'/images/edit.png',
				id : 'i3d_editcta',
				width : '24',
				height : '24',
				title : 'Edit',
				style : 'border: 1px solid #999; background: #eee; padding: 2px; margin: 0px 3px;'
			});
			
			tinymce.dom.Event.add(editButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor;
				ed.windowManager.bookmark = ed.selection.getBookmark('simple');
				//this.properties = ed.selection.getNode().title;
				//alert(this.properties);
				ed.execCommand("mceContentPanelGroup");
			});
			
			
			delButton = DOM.add('i3d_contentpanelgroup', 'img', {
				src : t.url+'/images/delete.png',
				id : 'i3d_delcta',
				width : '24',
				height : '24',
				title : 'Remove',
				style : 'border: 1px solid #999; background: #eee; padding: 2px; margin: 0px 3px;'
			});

			tinymce.dom.Event.add(delButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor, el = ed.selection.getNode();

				if ( el.nodeName == 'IMG' && ed.dom.hasClass(el, 'I3DContentPanelGroup') ) {
					ed.dom.remove(el);

					ed.execCommand('mceRepaint');
					return false;
				}
			});
			
		},
		
		
		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Content Panel Group',
				author : 'i3dTHEMES',
				authorurl : 'http://i3dthemes.com',
				infourl : 'http://i3dthemes.com',
				version : "1.0"
			};
		}
	});
	

	// Register plugin
	tinymce.PluginManager.add('i3d_cpg', tinymce.plugins.I3DContentPanelGroup);
})();