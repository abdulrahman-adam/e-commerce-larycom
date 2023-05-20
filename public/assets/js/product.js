// Ici la section arrière-plan movement dans page d'accuiel
//  On récupère toute l'image dans le parent de la balaise
let img_slider = document.querySelectorAll(".imgbackground");
//  On récupère la première l'Image
let etape = 0;
//  On récupère numbre de l'image
let nbr_img = img_slider.length;

//  Cette function permet enleave les class active sur toutes les images
function enleaverActiveImage() {
  for (let z = 0; z < nbr_img; z++) {
    // On récupère l'image inspecter par la boucle
    img_slider[z].classList.remove("active");
  }
}

setInterval(function() {
  etape++;
  if (etape >= nbr_img) {
    etape = 0;
  }
  enleaverActiveImage();
  img_slider[etape].classList.add("active");
}, 3000);



// La section de la toutes nos Catégories


let iconsDropDElement = document.querySelector('.iconsDrop');
let dropTitleDElement = document.querySelector('.dropTitle');
let allCategoriesDElement = document.querySelector('.allCategories');

dropTitleDElement.addEventListener('click', (eo) =>{
  iconsDropDElement.classList.toggle('active');
  allCategoriesDElement.classList.toggle('active');
})
