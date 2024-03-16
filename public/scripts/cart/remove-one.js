import { getCookie, setCookie } from '../cookies.js';

const removeButtons = document.querySelectorAll('.reduce-button');

for (const button of removeButtons) {
  button.addEventListener('click', (e) => {
    e.preventDefault();

    const itemLi = button.closest('.cart-item-li');

    const productId = button.dataset.productid;
    let initialQuantity = parseInt(itemLi.querySelector('.quantity-span').innerHTML);
    const itemPrice = parseFloat(button.dataset.productprice);
    const minServings = parseInt(button.dataset.minserving);
    const newQuantity = --initialQuantity;
    const newSubtotal = newQuantity * itemPrice;
    const newTotalPrice = parseFloat(document.querySelector('.total-price').innerHTML) - itemPrice;

    if (newQuantity < minServings || newQuantity < 1) {
      alert('Minimum required quantity required.');
      return;
    }

    try {
      //Getting the cookie, updating the product quantity and saving the new cart
      const cart = getCookie('cart');
      const newCart = cart.map((item) => {
        if (item.id === productId) {
          item.quantity = newQuantity;
        }
        return item;
      });
      setCookie('cart', JSON.stringify(newCart));

      //Changing the output data in the html file
      itemLi.querySelector('.quantity-span').innerHTML = newQuantity;
      itemLi.querySelector('.item-subtotal-price').innerHTML = newSubtotal.toFixed(2);
      document.querySelector('.total-price').innerHTML = newTotalPrice.toFixed(2);
    } catch (error) {
      console.log('An error ocurred');
      return;
    }
  });
}
