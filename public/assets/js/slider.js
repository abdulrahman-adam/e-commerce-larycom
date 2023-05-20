
let sliderContainer = document.getElementById('sliderContainer');
// console.log(sliderContainer)
let precedantElement = document.getElementById('pre');
// console.log(precedantElement)
let suivantElement = document.getElementById('next');
// console.log(suivantElement)

const listImage = [

    `<img class='img-slider' src="img/upload/camera.jpg" width='500px'alt="L'image de notre produits" >`,
    `<img class='img-slider'src="img/upload/drone.jpg" width='500px'alt="L'image de notre produits">`,
    `<img class='img-slider'src="img/upload/ordinateur.webp" width='500px'alt="L'image de notre produits">`,
    `<img class='img-slider'src="img/upload/drone-professionnel.jpg" width='500px'alt="L'image de notre produits">`,
    `<img class='img-slider'src="img/upload/camb.jpg" width='500px'alt="L'image de notre produits">`,
    `<img class='img-slider'src="img/upload/gps.jpg" width='500px'alt="L'image de notre produits">`,
    `<img class='img-slider'src="img/upload/rechercher-les-meilleurs.webp" width='500px'alt="L'image de notre produits">`,
    `<img class='img-slider'src="img/upload/ordinateur.webp" width='500px'alt="L'image de notre produits">`,

];

// note 

//  index commence 0


// pour récupère l'image premier 
// sliderContainer.innerHTML += listImage[0];

let m = 0;
sliderContainer.innerHTML += listImage[m];
sliderContainer.innerHTML += `<p>slide #${m+1} of ${listImage.length}</p>`;


// On laiser le button précédant disabled
precedantElement.setAttribute('disabled', 'disabled');

// On déplacement les images avec le button suivant


suivantElement.addEventListener('click', (eo) => {

    

    precedantElement.removeAttribute('disabled');

    m++;
    sliderContainer.innerHTML += listImage[m];
    // sliderContainer.innerHTML += `<p>slide #1 of 8</p>`;
    //  length array
    sliderContainer.innerHTML += `<p class='hide'>slide #${m+1} of ${listImage.length}</p>`;

    // Si 

    if(m+1 == listImage.length) {
        suivantElement.setAttribute('disabled', 'disabled');

    }


     // On suprime le current class active existe dans l'element 
     parentNumbers.getElementsByClassName("active-number")[0].classList.remove("active-number");
     // console.log('parentNumbers.getElementsByClassName("active-number")[0]'),
     // On ajout le class active pour l'element cliquer
     parentNumbers.getElementsByTagName('button')[m].classList.add("active-number");


})





precedantElement.addEventListener('click', (eo) => {

    suivantElement.removeAttribute('disabled');

    m--;

    sliderContainer.innerHTML += `<p>slide #${m+1} of ${listImage.length}</p>`;

    sliderContainer.innerHTML += listImage[m];
    // sliderContainer.innerHTML += `<p>slide #1 of 8</p>`;

    //  length array

    if(m == 0) {
        precedantElement.setAttribute('disabled', 'disabled');

    }


    // On suprime le current class active existe dans l'element 
    parentNumbers.getElementsByClassName("active-number")[0].classList.remove("active-number");
    // console.log('parentNumbers.getElementsByClassName("active-number")[0]'),
    // On ajout le class active pour l'element cliquer
    parentNumbers.getElementsByTagName('button')[m].classList.add("active-number");

})



// On suprimer la class active du numero dans les button  1-8

let parentNumbers = document.getElementsByClassName('numbers')[0];
// console.log(parentNumbers)
let allButtons2 = document.querySelectorAll('.mynumber');
// console.log(allButtons2)

allButtons2.forEach((item, index)=> {
    item.addEventListener('click', (eo) =>{
        // On suprime le current class active existe dans l'element 
        parentNumbers.getElementsByClassName("active-number")[0].classList.remove("active-number");
        // console.log('parentNumbers.getElementsByClassName("active-number")[0]'),
        // On ajout le class active pour l'element cliquer
        item.classList.add("active-number");

        sliderContainer.innerHTML += listImage[index];
        sliderContainer.innerHTML += `<p>slide #${index+1} of ${listImage.length}</p>`;

        // On récupère l'index d'item cliquer
        m = index;

        if(index == listImage.length-1){
            suivantElement.setAttribute('disabled', 'disabled');
            precedantElement.removeAttribute('disabled');

        } else if(index == 0) {
            
            suivantElement.removeAttribute('disabled');
            precedantElement.setAttribute('disabled', 'disabled');

        } else {
            suivantElement.removeAttribute('disabled');
            precedantElement.removeAttribute('disabled');

        } 

    })
})


// l'indice de tableau de l'élément courant