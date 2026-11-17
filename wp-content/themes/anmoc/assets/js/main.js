( function () {
	'use strict';

	/* Mobile menu */
	var toggle = document.querySelector( '.menu-button' );
	var nav = document.getElementById( 'main-nav' );
	if ( toggle && nav ) {
		var setOpen = function ( open ) {
			nav.classList.toggle( 'nav-open', open );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			toggle.setAttribute( 'aria-label', open ? toggle.dataset.close : toggle.dataset.open );
			document.body.classList.toggle( 'menu-open', open );
		};
		toggle.addEventListener( 'click', function () {
			setOpen( ! nav.classList.contains( 'nav-open' ) );
		} );
		nav.addEventListener( 'click', function ( e ) {
			if ( e.target.closest( 'a' ) ) {
				setOpen( false );
			}
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key && nav.classList.contains( 'nav-open' ) ) {
				setOpen( false );
				toggle.focus();
			}
		} );
		window.matchMedia( '(min-width: 1081px)' ).addEventListener( 'change', function ( mq ) {
			if ( mq.matches ) {
				setOpen( false );
			}
		} );
	}

	/* Font review switcher (Customizer → Font chữ) */
	var fontSwitch = document.querySelector( '.font-switch' );
	if ( fontSwitch ) {
		var trigger = fontSwitch.querySelector( '.font-switch-trigger' );
		var menu = fontSwitch.querySelector( '.font-switch-menu' );
		var names = {};
		fontSwitch.querySelectorAll( '.font-switch-option' ).forEach( function ( opt ) {
			names[ opt.dataset.font ] = opt.querySelector( 'strong' ).textContent;
		} );
		var current = function () {
			return document.documentElement.getAttribute( 'data-font' ) || 'A';
		};
		var sync = function () {
			var id = current();
			trigger.querySelector( 'b' ).textContent = id;
			trigger.setAttribute( 'aria-label', 'Đổi font chữ, đang chọn ' + id + ': ' + names[ id ] );
			fontSwitch.querySelectorAll( '.font-switch-option' ).forEach( function ( opt ) {
				opt.setAttribute( 'aria-pressed', opt.dataset.font === id ? 'true' : 'false' );
			} );
		};
		var openMenu = function ( open ) {
			menu.hidden = ! open;
			trigger.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		};
		sync();
		trigger.addEventListener( 'click', function () {
			openMenu( menu.hidden );
		} );
		menu.addEventListener( 'click', function ( e ) {
			var opt = e.target.closest( '.font-switch-option' );
			if ( ! opt ) {
				return;
			}
			var id = opt.dataset.font;
			if ( 'A' === id ) {
				document.documentElement.removeAttribute( 'data-font' );
			} else {
				document.documentElement.setAttribute( 'data-font', id );
			}
			try {
				localStorage.setItem( 'anmoc-font', id );
			} catch ( err ) {}
			sync();
			openMenu( false );
			trigger.focus();
		} );
		document.addEventListener( 'pointerdown', function ( e ) {
			if ( ! menu.hidden && ! fontSwitch.contains( e.target ) ) {
				openMenu( false );
			}
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key && ! menu.hidden ) {
				openMenu( false );
				trigger.focus();
			}
		} );
	}

	/* FAQ accordion: one item open at a time */
	document.querySelectorAll( '.faq-list' ).forEach( function ( list ) {
		list.addEventListener( 'click', function ( e ) {
			var button = e.target.closest( '.faq-item button' );
			if ( ! button ) {
				return;
			}
			var item = button.closest( '.faq-item' );
			var willOpen = ! item.classList.contains( 'open' );
			list.querySelectorAll( '.faq-item' ).forEach( function ( other ) {
				var open = other === item && willOpen;
				other.classList.toggle( 'open', open );
				other.querySelector( 'button' ).setAttribute( 'aria-expanded', open ? 'true' : 'false' );
				other.querySelector( 'button i' ).textContent = open ? '−' : '+';
				other.querySelector( '.faq-answer' ).hidden = ! open;
			} );
		} );
	} );
} )();
