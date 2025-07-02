export function initNavigation() {
	const toggle = document.querySelector( '.menu-toggle' );
	const nav = document.querySelector( '.primary-nav' );

	if ( ! toggle || ! nav ) return;

	toggle.addEventListener( 'click', () => {
		const expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
		toggle.setAttribute( 'aria-expanded', ! expanded );
		nav.classList.toggle( 'is-open' );
	} );

	// Toggle sous-menus au clic
	nav.querySelectorAll( '.menu-item-has-children > a' ).forEach( ( link ) => {
		link.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			const li = link.parentNode;
			li.classList.toggle( 'submenu-open' );
		} );
	} );
}
