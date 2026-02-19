import A11yDialog from 'a11y-dialog';

/**
 * Mobile menu
 */
const componentMobileMenu = (args) => {
	// setup args
	const menu = args.menu;
	const site = args.site;
	const toggles = args.toggles;

	// validate
	if (!menu || !site || !toggles.length) {
		return;
	}

	// setup a11y dialog
	const dialog = new A11yDialog(site);

	// tasks to open menu visually
	const openMenu = () => {
		document.body.classList.add('is-active-menu');
	};

	// tasks to close menu visually
	const closeMenu = () => {
		document.body.classList.add('is-closing-menu');
		setTimeout(() => {
			document.body.classList.remove('is-active-menu');
			document.body.classList.remove('is-closing-menu');
		}, 200);
	};

	// hooks
	dialog.on('show', () => openMenu());
	dialog.on('hide', () => closeMenu());

	// toggle click
	const handleToggle = () => {
		if (document.body.classList.contains('is-active-menu')) {
			dialog.hide();
		} else {
			dialog.show();
		}
	};

	// close on anchor link
	const anchorLinks = menu.querySelectorAll('a[href*="#"]');
	for (let i = 0; i < anchorLinks.length; i++) {
		if (anchorLinks[i].getAttribute('href') !== '#') {
			anchorLinks[i].addEventListener('click', () => {
				dialog.hide();
			});
		}
	}

	for (let i = 0; i < toggles.length; i++) {
		toggles[i].addEventListener('click', handleToggle, false);
	}
};

/**
 * Init mobile menu
 */
export default function initMobileMenu() {
	componentMobileMenu({
		menu: document.querySelector('.js-mobile-menu'),
		site: document.querySelector('.js-page'),
		toggles: document.querySelectorAll('.js-menu-toggle'),
	});
}
