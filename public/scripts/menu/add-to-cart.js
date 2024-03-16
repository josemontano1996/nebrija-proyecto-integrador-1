import { setCookie, getCookie } from './../cookies.js';

const addingToCartForms = document.querySelectorAll('.add-form');

for (const addForm of addingToCartForms) {
  addForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    //parsing the form data
    const form = new FormData(addForm);

    const id = form.get('id');
    const minServings = parseInt(form.get('min_servings'));
    const quantity = parseInt(form.get('quantity'));
    try {
      // Get the cart from the cookie
      let cart = getCookie('cart') || [];
      //Checkin if the item already exists in the cart
      const existingItemIndex = cart.findIndex((item) => item.id === id);

      //If the item already exists in the cart, proceed to add the quantity to the existing quantity
      if (existingItemIndex !== -1) {
        //Check if the total quantity is less than the minimum servings, this helps in case a user tries to add a quantity lower than the minServings but that still reachs the minServings when added to the existing quantity
        if (quantity + cart[existingItemIndex].quantity < minServings) {
          alert('Minimum servings not reached, order more quantity to proceed.');
          return;
        }
        //If the total quantity is greater than the minimum servings, proceed to add the quantity to the existing quantity
        cart[existingItemIndex].quantity += quantity;
      } else {
        //If the item does not exist in the cart, check if the quantity is less than the minimum servings
        if (quantity < minServings) {
          alert('Minimum servings not reached, order more quantity to proceed.');
          return;
        }
        //In case there is no such item in the cart, add the item to the cart
        cart.push({ id, quantity });
      }

      //Save the cart to the cookie
      setCookie('cart', JSON.stringify(cart), 7);

      alert('Item added to cart successfully');
    } catch (error) {
      console.log(error);
      alert('An error occured while adding the item to your cart.');
    }
  });
}
