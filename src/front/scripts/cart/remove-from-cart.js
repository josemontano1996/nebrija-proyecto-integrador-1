import { getCookie, setCookie } from '../cookies.js';

const removeButtons = document.querySelectorAll('.remove-button');

for (const button of removeButtons) {
  button.addEventListener('click', (e) => {
    const productId = e.target.dataset.productid;

    try {
      const cart = getCookie('cart');

      const newCart = cart.filter((item) => item.id !== productId);

      setCookie('cart', JSON.stringify(newCart));

      button.closest('.cart-item-li').style.display = 'none';
    } catch (e) {
      console.log('An error ocurred');
      return;
    }
  });
}
