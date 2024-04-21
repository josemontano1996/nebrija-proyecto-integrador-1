import { scrollToId } from '../scroll-to-id.js';

const chefButton = document.getElementById('chef-scroll');
const experienceButton = document.getElementById('experience-scroll');

chefButton && chefButton.addEventListener('click', () => scrollToId('chef'));
experienceButton && experienceButton.addEventListener('click', () => scrollToId('experience'));
