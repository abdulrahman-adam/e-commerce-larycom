
let parentElement25 = document.querySelector('.table');
let addToPanier = document.querySelector('#panierClick');
let incrementElement = document.querySelector('.increment');
let clickElement = document.querySelector('.strong');
let youElement = document.querySelector('.you');

addToPanier.addEventListener('click', (eo) =>{
    parentElement25.style.opacity = '1';
})

addToPanier.addEventListener('click', (eo) =>{
    youElement.style.display = 'block';
})

// la déviation d'increment

// update = (n) => {
//     incrementElement.innerText = (n < 200 && n > 0 ) ? `${n}` : n;
// } 

// let q = 0;

// clickElement.addEventListener('click', () => update(++q));
// clickElement.addEventListener('click', (eo) => {
//     update(++q);
//     incrementElement.style.color = 'green';
// });