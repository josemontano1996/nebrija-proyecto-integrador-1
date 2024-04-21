const form = document.getElementById('create-order-form');

if (form) {
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    let response;

    try {
      response = await fetch('/user/order', {
        method: 'POST',
        body: formData,
      });
    } catch (error) {
      alert('Something went wrong, please try again later');
      return;
    }

    const responseData = await response.json();

    if (!response.ok) {
      alert(responseData || 'Something went wrong, please try again later');
      return;
    }

    window.location.href = responseData;
  });
}
