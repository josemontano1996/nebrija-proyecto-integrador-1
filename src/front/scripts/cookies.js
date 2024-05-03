/**
 * Sets a cookie with the specified name, value, and expiration days.
 * @param {string} cname - The name of the cookie.
 * @param {string} cvalue - The value of the cookie.
 * @param {number} [exdays=30] - The number of days until the cookie expires (default is 30 days).
 */
export function setCookie(cname, cvalue, exdays = 30) {
  // Create a new date object
  const d = new Date();
  // Set the expiration date
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  // Set the cookie
  let expires = 'expires=' + d.toUTCString();
  document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';
}

/**
 * Retrieves the value of a cookie by its name and return its value in JSON format.
 * @param {string} cname - The name of the cookie.
 * @returns {any} The value of the cookie in JSON format, or null if the cookie does not exist.
 */
export function getCookie(cname) {
  // Get the cookie by its name
  let name = cname + '=';
  let ca = document.cookie.split(';');
  // Loop through the cookies
  for (let i = 0; i < ca.length; i++) {
    // Get the current cookie
    let c = ca[i];
    // Remove leading spaces
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    // Check if the cookie is the one we are looking for
    if (c.indexOf(name) == 0) {
      const decodedCookie = decodeURIComponent(c.substring(name.length, c.length));
      return JSON.parse(decodedCookie);
    }
  }
  return null;
}
