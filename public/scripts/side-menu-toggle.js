const hamburgerButton = document.getElementById('hamburger-button');
const sideMenu = document.getElementById('side-menu');

function toggleSideMenu() {
  sideMenu.classList.toggle('hidden');
}

function closeSideMenu(event) {
  if (
    !sideMenu.contains(event.target) &&
    !event.target.matches('#hamburger-button') &&
    !sideMenu.classList.contains('hidden')
  ) {
    sideMenu.classList.add('hidden');
  }
}

hamburgerButton.addEventListener('click', toggleSideMenu);
document.addEventListener('click', closeSideMenu);
