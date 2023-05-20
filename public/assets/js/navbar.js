
let allsection = document.querySelector('.section');
let ulNavbarElement = document.querySelector('.ulNavbar');
let wedjetElement = document.querySelector('.navbarParentSpan');


wedjetElement.addEventListener('click', (eo) => {
    wedjetElement.classList.toggle('active');
    ulNavbarElement.classList.toggle('active');
    allsection.classList.toggle('active');
})


