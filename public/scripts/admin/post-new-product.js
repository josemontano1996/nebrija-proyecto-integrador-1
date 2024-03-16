const uploadForm = document.getElementById('upload-product-form');

async function uploadFormHandler(event) {
  event.preventDefault();

  const form = new FormData(uploadForm);
  let response;

  try {
    response = await fetch('/admin/product/new', {
      method: 'POST',
      body: form,
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
}

uploadForm.addEventListener('submit', uploadFormHandler);
