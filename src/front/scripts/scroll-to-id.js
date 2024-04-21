/**
 * Scrolls to the specified element with the given ID.
 * @param {string} id - The ID of the element to scroll to.
 */
export function scrollToId(id) {
  const scrollSection = document.getElementById(id);

  const header = document.getElementById('header');
  const offset = header ? header.clientHeight : 70;
  const targetPosition = scrollSection.offsetTop - offset;
  window.scrollTo({ top: targetPosition, behavior: 'smooth' });
}
