const deleteButtons = document.querySelectorAll('#delete-button');

for (const deleteButton of deleteButtons) {
  deleteButton.addEventListener('click', async (e) => {
    e.preventDefault();

    const productId = e.target.dataset.productid;

    //encoding the image url to be able to send it as a query parameter
    const encodedImageUrl = encodeURIComponent(e.target.dataset.imageurl);

    let response;
    try {
      response = await fetch(
        `/admin/product/delete?productId=${productId}&imageUrl=${encodedImageUrl}`,
        {
          method: 'DELETE',
        }
      );
    } catch (error) {
      alert('Something went wrong, please try again later');
      return;
    }

    const responseData = await response.json();

    if (!response.ok) {
      alert(responseData || 'Something went wrong, please try again later');
      return;
    }

    const listElement = deleteButton.closest('.menu-list-item');

    listElement.style.display = 'none';
  });
}
