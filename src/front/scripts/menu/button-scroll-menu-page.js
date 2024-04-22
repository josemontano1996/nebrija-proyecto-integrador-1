import { scrollToId } from '../scroll-to-id.js';

const navigationButton = document.getElementById('menu-scroll');


navigationButton && navigationButton.addEventListener('click', () => scrollToId('menu'));

