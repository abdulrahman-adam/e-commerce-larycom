




let sectionElement = document.querySelector('.section');
let pnierElement = document.querySelector('.panierPrent');

function panier() {
    sectionElement.style.marginTop = '30px';
    pnierElement.style.display = 'block';
    ulNavbarElement.classList.toggle('active');
}


function okElement() {
    pnierElement.style.display = 'none';
    sectionElement.style.marginTop = '0';
}

