
  const track = document.querySelector('.carousel-track');
  const items = document.querySelectorAll('.carousel-item');
  const nextBtn = document.querySelector('.next');
  const prevBtn = document.querySelector('.prev');
  const dots = document.querySelectorAll('.dot');
  let index = 0;

  function updateCarousel() {
    track.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach(dot => dot.classList.remove('active'));
    dots[index].classList.add('active');
  }

  nextBtn.addEventListener('click', () => {
    index = (index + 1) % items.length;
    updateCarousel();
  });

  prevBtn.addEventListener('click', () => {
    index = (index - 1 + items.length) % items.length;
    updateCarousel();
  });

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      index = i;
      updateCarousel();
    });
  });

  
  setInterval(() => {
    index = (index + 1) % items.length;
    updateCarousel();
  }, 6000);

const btnCarrito = document.getElementById("btnCarrito");
const carrito = document.getElementById("carrito");
const cerrarCarrito = document.getElementById("cerrarCarrito");

btnCarrito.addEventListener("click", () => {
  carrito.classList.add("abierto");
});

cerrarCarrito.addEventListener("click", () => {
  carrito.classList.remove("abierto");
});
