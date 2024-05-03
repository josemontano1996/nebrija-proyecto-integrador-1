import { getCookie, setCookie } from '../cookies.js';

const removeButtons = document.querySelectorAll('.remove-button');

for (const button of removeButtons) {
  button.addEventListener('click', (e) => {
    //Getting the product id and the subtotal price of the item to be removed
    const productId = e.target.dataset.productid;
    const subtotal = parseFloat(
      button.closest('.cart-item-li').querySelector('.item-subtotal-price').innerHTML
    ).toFixed(2);

    //Getting the total price of the cart
    const totalPriceElement = document.querySelector('.total-price');
    const totalPrice = parseFloat(totalPriceElement.innerHTML).toFixed(2);

    try {
      //Getting the cookie, removing the product and saving the new cart
      const cart = getCookie('cart');

      const newCart = cart.filter((item) => item.id !== productId);

      setCookie('cart', JSON.stringify(newCart));
      // Hiding the item from the cart and updating the total price
      button.closest('.cart-item-li').style.display = 'none';
      totalPriceElement.innerHTML = (totalPrice - subtotal).toFixed(2);
    } catch (e) {
      console.log('An error occurred while removing the item from the cart.');
      return;
    }
  });
}
