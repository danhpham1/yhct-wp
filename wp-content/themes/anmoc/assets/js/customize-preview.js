/* global wp, anmocPreview */
( function ( api ) {
	'use strict';

	var root = document.documentElement;

	/* Colours → CSS custom properties, no reload. */
	anmocPreview.colors.forEach( function ( key ) {
		api( 'color_' + key, function ( value ) {
			value.bind( function ( color ) {
				root.style.setProperty( '--' + key, color );
			} );
		} );
	} );

	/* Sizes, radius, width → CSS custom properties. */
	Object.keys( anmocPreview.vars ).forEach( function ( id ) {
		var cssVar = anmocPreview.vars[ id ][ 0 ];
		var unit = anmocPreview.vars[ id ][ 1 ];
		api( id, function ( value ) {
			value.bind( function ( number ) {
				var n = parseFloat( number );
				if ( isNaN( n ) ) {
					return;
				}
				root.style.setProperty( cssVar, '%' === unit ? String( n / 100 ) : n + unit );
			} );
		} );
	} );

	/* Own font for one heading (e.g. hero title): load it and rewrite that field's <style>. */
	Object.keys( anmocPreview.targets ).forEach( function ( id ) {
		api( id, function ( value ) {
			value.bind( function ( name ) {
				var style = document.getElementById( 'anmoc-font-' + id );
				var url = anmocPreview.fonts[ name ];
				if ( ! style ) {
					style = document.createElement( 'style' );
					style.id = 'anmoc-font-' + id;
					document.head.appendChild( style );
				}
				if ( url && ! document.querySelector( 'link[data-anmoc-font="' + name + '"]' ) ) {
					var link = document.createElement( 'link' );
					link.rel = 'stylesheet';
					link.href = url;
					link.setAttribute( 'data-anmoc-font', name );
					document.head.appendChild( link );
				}
				style.textContent = url ?
					'html:is([data-font],:not([data-font])) ' + anmocPreview.targets[ id ] + '{font-family:"' + name + '",' + anmocPreview.fallback[ name ] + '}' :
					'';
			} );
		} );
	} );

	/* Checkboxes → body classes (class is added when the option is off). */
	Object.keys( anmocPreview.classes ).forEach( function ( id ) {
		api( id, function ( value ) {
			value.bind( function ( on ) {
				document.body.classList.toggle( anmocPreview.classes[ id ], ! on );
			} );
		} );
	} );

	/*
	 * Fields refresh in place through selective refresh. A field that has no
	 * visible spot on the current page (e.g. used only in an attribute)
	 * falls back to reloading the preview.
	 */
	api.bind( 'preview-ready', function () {
		anmocPreview.live.forEach( function ( id ) {
			api( id, function ( value ) {
				value.bind( function () {
					var partial = api.selectiveRefresh.partial( id );
					if ( ! partial || ! partial.placements().length ) {
						api.selectiveRefresh.requestFullRefresh();
					}
				} );
			} );
		} );
	} );

	/*
	 * Text of services, doctors, testimonials and FAQ: tell the controls pane
	 * which items this page shows, so a pencil can open their fields.
	 */
	api.bind( 'preview-ready', function () {
		function sendSchema() {
			api.preview.send( 'anmoc-post-schema', window.anmocPostSchema || {} );
		}
		// "active" = the controls pane is now listening to this preview (earlier messages are dropped).
		api.preview.bind( 'active', sendSchema );
		api.preview.bind( 'anmoc-post-schema-request', sendSchema );
	} );

	/*
	 * Click-to-change images: hovering any picture marked data-anmoc-img shows
	 * an "Đổi ảnh" button; the controls pane opens the Media Library for it.
	 */
	api.bind( 'preview-ready', function () {
		var style = document.createElement( 'style' );
		style.textContent =
			'.anmoc-img-edit{position:fixed;z-index:2147483000;display:none;align-items:center;gap:6px;margin:0;padding:6px 12px 6px 8px;' +
			'border:2px solid #fff;border-radius:999px;background:#3582c4;color:#fff;font:600 13px/1.2 -apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;' +
			'letter-spacing:0;text-transform:none;box-shadow:0 2px 6px rgba(0,0,0,.3);cursor:pointer}' +
			'.anmoc-img-edit.is-on{display:inline-flex}.anmoc-img-edit:hover,.anmoc-img-edit:focus{background:#2271b1;outline:none}' +
			'.anmoc-img-edit svg{width:16px;height:16px;fill:currentColor}' +
			'.anmoc-img-edit.is-small{padding:5px}.anmoc-img-edit.is-small span{display:none}' +
			'.anmoc-img-target{outline:2px dashed #3582c4!important;outline-offset:-2px}';
		document.head.appendChild( style );

		var btn = document.createElement( 'button' );
		btn.type = 'button';
		btn.className = 'anmoc-img-edit';
		btn.innerHTML = '<svg viewBox="0 0 20 20" aria-hidden="true"><path d="M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z"/></svg><span>Đổi ảnh</span>';
		document.body.appendChild( btn );

		var target = null;
		var pending = 0;
		var x = null;
		var y = null;

		function setTarget( el ) {
			if ( target === el ) {
				return;
			}
			if ( target ) {
				target.classList.remove( 'anmoc-img-target' );
			}
			target = el;
			if ( el ) {
				el.classList.add( 'anmoc-img-target' );
				btn.setAttribute( 'aria-label', 'Đổi ảnh: ' + ( el.getAttribute( 'data-anmoc-img-label' ) || '' ) );
				btn.title = btn.getAttribute( 'aria-label' );
			}
		}

		// Look through everything under the pointer, so overlays and links on top of a picture don't hide it.
		function imageAt( px, py ) {
			var stack = document.elementsFromPoint( px, py );
			for ( var i = 0; i < stack.length; i++ ) {
				if ( stack[ i ] === btn || btn.contains( stack[ i ] ) ) {
					return target;
				}
				if ( stack[ i ].hasAttribute && stack[ i ].hasAttribute( 'data-anmoc-img' ) ) {
					return stack[ i ];
				}
			}
			return null;
		}

		// Pictures can be clipped (the arched hero), so the pointer may cross a cut-off
		// corner on its way to the button: stay on the current picture while inside its box.
		function stillOnTarget( px, py ) {
			if ( ! target || ! document.contains( target ) ) {
				return false;
			}
			var r = target.getBoundingClientRect();
			var pad = 24;
			return px >= r.left - pad && px <= r.right + pad && py >= r.top - pad && py <= r.bottom + pad;
		}

		function place() {
			pending = 0;
			var el = null === x ? null : imageAt( x, y );
			if ( ! el && null !== x && stillOnTarget( x, y ) ) {
				el = target;
			}
			if ( el && ! document.contains( el ) ) {
				el = null;
			}
			setTarget( el );
			if ( ! el ) {
				btn.classList.remove( 'is-on' );
				return;
			}
			var r = el.getBoundingClientRect();
			// Small pictures (logo) get a round icon on their top-left corner so the text pencils beside them stay clickable.
			var small = r.width < 160 || r.height < 90;
			btn.classList.toggle( 'is-small', small );
			btn.classList.add( 'is-on' ); // visible first, so its width can be measured
			if ( small ) {
				btn.style.top = Math.max( 4, r.top - 14 ) + 'px';
				btn.style.left = Math.max( 4, r.left - 18 ) + 'px';
			} else {
				// Top centre stays inside rounded or clipped pictures.
				btn.style.top = Math.max( 8, Math.min( Math.max( r.top, 0 ) + 22, r.bottom - 44 ) ) + 'px';
				btn.style.left = Math.max( 8, r.left + ( r.width - btn.offsetWidth ) / 2 ) + 'px';
			}
		}

		function schedule() {
			if ( ! pending ) {
				pending = window.requestAnimationFrame( place );
			}
		}

		document.addEventListener( 'mousemove', function ( e ) {
			x = e.clientX;
			y = e.clientY;
			schedule();
		}, { passive: true } );
		window.addEventListener( 'scroll', schedule, { passive: true } );
		document.documentElement.addEventListener( 'mouseleave', function () {
			x = null;
			schedule();
		} );

		btn.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			e.stopPropagation();
			if ( ! target ) {
				return;
			}
			api.preview.send( 'anmoc-image-edit', {
				key: target.getAttribute( 'data-anmoc-img' ),
				label: target.getAttribute( 'data-anmoc-img-label' ) || '',
				current: parseInt( target.getAttribute( 'data-anmoc-img-current' ), 10 ) || 0
			} );
		} );
	} );
} )( wp.customize );
