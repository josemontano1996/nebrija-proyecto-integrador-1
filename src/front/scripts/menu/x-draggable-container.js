const draggableList = document.querySelectorAll('.dragable');
let isDragStart = false,
  prevPageX,
  prevScrollLeft;

function handleMouseDown(event) {
  //updating variables dependeing on mouse down event
   isDragStart = true;
  prevPageX = event.pageX;
  prevScrollLeft = event.target.closest('.dragable').scrollLeft;
}

function handleMouseMove(event) {
  if (!isDragStart) return;
  event.preventDefault();

  // Calculate the difference
  let positionDif = event.pageX - prevPageX;
  // scroll the element
  event.target.closest('.dragable').scrollLeft = prevScrollLeft - positionDif;
}

function handleMouseUp(event) {
  // Update the previous page X value
  isDragStart = false;
}

for (let i = 0; i < draggableList.length; i++) {
  draggableList[i].addEventListener('mousedown', handleMouseDown);
  draggableList[i].addEventListener('mousemove', handleMouseMove);
}

document.addEventListener('mouseup', handleMouseUp);
