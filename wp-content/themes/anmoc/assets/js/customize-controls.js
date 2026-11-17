/* global wp, jQuery, anmocSectionUrls */
( function ( api, $ ) {
	'use strict';

	function moveButtons( index, total ) {
		return (
			'<button type="button" class="button-link anmoc-up" aria-label="Chuyển lên"' + ( 0 === index ? ' disabled' : '' ) + '>↑</button>' +
			'<button type="button" class="button-link anmoc-down" aria-label="Chuyển xuống"' + ( index === total - 1 ? ' disabled' : '' ) + '>↓</button>'
		);
	}

	function swap( list, from, to ) {
		if ( to < 0 || to >= list.length ) {
			return list;
		}
		var copy = list.slice();
		var item = copy.splice( from, 1 )[ 0 ];
		copy.splice( to, 0, item );
		return copy;
	}

	/* ---------- Repeater: JSON array of rows ---------- */
	api.controlConstructor.anmoc_repeater = api.Control.extend( {
		ready: function () {
			var control = this;
			var list = control.container.find( '.anmoc-rows' );
			var timer;

			control.rows = function () {
				try {
					var rows = JSON.parse( control.setting.get() || '[]' );
					return Array.isArray( rows ) ? rows : [];
				} catch ( e ) {
					return [];
				}
			};

			// Local copy so fast typing in several inputs never reads a stale setting.
			control.state = control.rows();

			control.save = function ( rows ) {
				control.state = rows;
				control.setting.set( JSON.stringify( rows ) );
			};

			control.render = function () {
				var rows = control.state;
				list.empty();
				rows.forEach( function ( row, i ) {
					var item = $( '<li class="anmoc-row" />' ).attr( 'data-index', i );
					var head = $( '<div class="anmoc-row-head" />' );
					head.append( '<strong>Mục ' + ( i + 1 ) + '</strong>' );
					head.append(
						'<span class="anmoc-row-actions">' + moveButtons( i, rows.length ) +
						'<button type="button" class="button-link button-link-delete anmoc-remove" aria-label="Xóa mục">Xóa</button></span>'
					);
					item.append( head );
					control.params.fields.forEach( function ( field ) {
						var id = control.id + '-' + i + '-' + field.key;
						var input = 'textarea' === field.type ? $( '<textarea rows="3" />' ) : $( '<input type="text" />' );
						input.attr( { id: id, 'data-key': field.key } ).val( row[ field.key ] || '' );
						item.append( $( '<label />' ).attr( 'for', id ).text( field.label ) ).append( input );
					} );
					list.append( item );
				} );
			};

			list.on( 'input', 'input, textarea', function () {
				var el = $( this );
				var rows = control.state;
				var i = parseInt( el.closest( '.anmoc-row' ).attr( 'data-index' ), 10 );
				rows[ i ][ el.attr( 'data-key' ) ] = el.val();
				clearTimeout( timer );
				timer = setTimeout( function () {
					control.save( rows );
				}, 250 );
			} );

			list.on( 'click', '.anmoc-up, .anmoc-down, .anmoc-remove', function () {
				var btn = $( this );
				var rows = control.state.slice();
				clearTimeout( timer );
				var i = parseInt( btn.closest( '.anmoc-row' ).attr( 'data-index' ), 10 );
				if ( btn.hasClass( 'anmoc-remove' ) ) {
					rows.splice( i, 1 );
				} else {
					rows = swap( rows, i, btn.hasClass( 'anmoc-up' ) ? i - 1 : i + 1 );
				}
				control.save( rows );
				control.render();
			} );

			control.container.on( 'click', '.anmoc-add-row', function () {
				var rows = control.state.slice();
				clearTimeout( timer );
				var blank = {};
				control.params.fields.forEach( function ( field ) {
					blank[ field.key ] = '';
				} );
				rows.push( blank );
				control.save( rows );
				control.render();
				list.find( '.anmoc-row' ).last().find( 'input, textarea' ).first().trigger( 'focus' );
			} );

			control.render();
		}
	} );

	/* ---------- Layout: "key,!hiddenKey,..." ---------- */
	api.controlConstructor.anmoc_layout = api.Control.extend( {
		ready: function () {
			var control = this;
			var list = control.container.find( '.anmoc-layout' );
			var labels = control.params.items;

			control.items = function () {
				var seen = {};
				var items = [];
				String( control.setting.get() || '' ).split( ',' ).forEach( function ( token ) {
					token = token.trim();
					var key = token.replace( /^!/, '' );
					if ( labels[ key ] && ! seen[ key ] ) {
						seen[ key ] = true;
						items.push( { key: key, on: '!' !== token.charAt( 0 ) } );
					}
				} );
				Object.keys( labels ).forEach( function ( key ) {
					if ( ! seen[ key ] ) {
						items.push( { key: key, on: true } );
					}
				} );
				return items;
			};

			control.save = function ( items ) {
				control.setting.set( items.map( function ( item ) {
					return ( item.on ? '' : '!' ) + item.key;
				} ).join( ',' ) );
			};

			control.render = function () {
				var items = control.items();
				list.empty();
				items.forEach( function ( item, i ) {
					var id = control.id + '-' + item.key;
					var li = $( '<li class="anmoc-layout-item" />' ).attr( 'data-index', i ).toggleClass( 'is-off', ! item.on );
					li.append(
						$( '<label />' ).attr( 'for', id )
							.append( $( '<input type="checkbox" />' ).attr( 'id', id ).prop( 'checked', item.on ) )
							.append( $( '<span />' ).text( labels[ item.key ] ) )
					);
					li.append( '<span class="anmoc-row-actions">' + moveButtons( i, items.length ) + '</span>' );
					list.append( li );
				} );
			};

			list.on( 'change', 'input', function () {
				var items = control.items();
				var i = parseInt( $( this ).closest( 'li' ).attr( 'data-index' ), 10 );
				items[ i ].on = this.checked;
				control.save( items );
				control.render();
			} );

			list.on( 'click', '.anmoc-up, .anmoc-down', function () {
				var items = control.items();
				var i = parseInt( $( this ).closest( 'li' ).attr( 'data-index' ), 10 );
				control.save( swap( items, i, $( this ).hasClass( 'anmoc-up' ) ? i - 1 : i + 1 ) );
				control.render();
			} );

			control.render();
		}
	} );

	/* ---------- "Đổi ảnh" clicked in the preview ---------- */

	// Theme image fields and the logo: open their own control's Media Library.
	function editFieldImage( id ) {
		var control = api.control( id );
		if ( ! control ) {
			return;
		}
		control.focus( {
			completeCallback: function () {
				if ( control.openFrame ) {
					control.openFrame( $.Event( 'click' ) );
				}
			}
		} );
	}

	// Featured image of a post: a dynamic setting the server previews and saves on publish.
	function editPostImage( postId, data ) {
		var id = 'anmoc_thumb[' + postId + ']';
		var setting = api( id );
		if ( ! setting ) {
			setting = new api.Setting( id, data.current || 0, { transport: 'refresh', previewer: api.previewer } );
			api.add( setting );
		}
		var frame = wp.media( {
			title: 'Đổi ảnh' + ( data.label ? ': ' + data.label : '' ),
			library: { type: 'image' },
			button: { text: 'Dùng ảnh này' },
			multiple: false
		} );
		frame.on( 'open', function () {
			var current = parseInt( setting.get(), 10 );
			frame.content.mode( 'browse' );
			if ( current ) {
				var attachment = wp.media.attachment( current );
				attachment.fetch();
				frame.state().get( 'selection' ).reset( [ attachment ] );
			}
		} );
		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first();
			if ( attachment ) {
				setting.set( attachment.id );
			}
		} );
		frame.open();
	}

	/* ---------- Pencil on a service / doctor / testimonial / FAQ text ---------- */

	var postSchema = {};

	// Build (once) a section holding every text field of that item, then focus the clicked one.
	function editPostText( postId, field ) {
		var info = postSchema[ postId ];
		var sectionId = 'anmoc_post_' + postId;
		if ( ! info ) {
			// Not received yet: ask the preview, then try once more.
			api.previewer.send( 'anmoc-post-schema-request' );
			if ( ! editPostText.retried ) {
				editPostText.retried = true;
				setTimeout( function () {
					editPostText( postId, field );
					editPostText.retried = false;
				}, 400 );
			}
			return;
		}
		if ( ! api.section( sectionId ) ) {
			api.section.add( new api.Section( sectionId, {
				title: info.title,
				description: info.note,
				customizeAction: 'Đang sửa',
				priority: 1
			} ) );
		}
		Object.keys( info.fields ).forEach( function ( key ) {
			var f = info.fields[ key ];
			var id = 'anmoc_post[' + postId + '][' + key + ']';
			if ( ! api.has( id ) ) {
				api.add( new api.Setting( id, f.value, { transport: 'postMessage', previewer: api.previewer } ) );
			}
			if ( ! api.control( id ) ) {
				api.control.add( new api.Control( id, {
					type: f.type,
					label: f.label,
					section: sectionId,
					setting: id,
					priority: f.order
				} ) );
			}
		} );
		var control = api.control( 'anmoc_post[' + postId + '][' + field + ']' );
		if ( control ) {
			control.focus();
		}
	}

	api.bind( 'ready', function () {
		api.previewer.bind( 'anmoc-post-schema', function ( schema ) {
			$.extend( postSchema, schema );
		} );
		// Core sends this when a pencil is clicked; it finds no control for these dynamic settings, we build it.
		api.previewer.bind( 'focus-control-for-setting', function ( settingId ) {
			var m = /^anmoc_post\[(\d+)\]\[([a-z_]+)\]$/.exec( settingId );
			if ( m ) {
				editPostText( m[ 1 ], m[ 2 ] );
			}
		} );
		api.previewer.bind( 'anmoc-image-edit', function ( data ) {
			var parts = String( ( data && data.key ) || '' ).split( ':' );
			if ( 'mod' === parts[ 0 ] && parts[ 1 ] ) {
				editFieldImage( parts[ 1 ] );
			} else if ( 'thumb' === parts[ 0 ] && parseInt( parts[ 1 ], 10 ) ) {
				editPostImage( parseInt( parts[ 1 ], 10 ), data );
			}
		} );
	} );

	/* ---------- Opening a section shows the page it edits ---------- */
	api.bind( 'ready', function () {
		Object.keys( anmocSectionUrls ).forEach( function ( id ) {
			api.section( id, function ( section ) {
				section.expanded.bind( function ( expanded ) {
					var url = anmocSectionUrls[ id ];
					if ( expanded && url && api.previewer.previewUrl() !== url ) {
						api.previewer.previewUrl.set( url );
					}
				} );
			} );
		} );
	} );
} )( wp.customize, jQuery );
