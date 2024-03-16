const form = document.querySelector('form');

updateProduct = async (event) => {
  event.preventDefault();

  const formData = new FormData(form);

  let response;
  try {
    response = await fetch('/admin/product/update', {
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
};

form.addEventListener('submit', updateProduct);
