import { getCookie, setCookie } from '../cookies.js';

const addButtons = document.querySelectorAll('.add-button');

for (const addButton of addButtons) {
  addButton.addEventListener('click', (e) => {
    e.preventDefault();
    const itemLi = addButton.closest('.cart-item-li');

    const productId = addButton.dataset.productid;
    let initialQuantity = parseInt(itemLi.querySelector('.quantity-span').innerHTML);
    const itemPrice = parseFloat(addButton.dataset.productprice);
    const newQuantity = ++initialQuantity;
    const newSubtotal = newQuantity * itemPrice;
    const newTotalPrice = parseFloat(document.querySelector('.total-price').innerHTML) + itemPrice;

    try {
      //Getting the cookie, updating the product quantity and saving the new cart
      const cart = getCookie('cart');

      const newCart = cart.map((item) => {
        if (item.id === productId) {
          item.quantity = newQuantity;
        }
        return item;
      });
      console.log(newCart);
      setCookie('cart', JSON.stringify(newCart));

      //Changing the output data in the html file
      itemLi.querySelector('.quantity-span').innerHTML = newQuantity;
      itemLi.querySelector('.item-subtotal-price').innerHTML = newSubtotal.toFixed(2);
      document.querySelector('.total-price').innerHTML = newTotalPrice.toFixed(2);
    } catch (error) {
      console.log(error);
      return;
    }
  });
}
