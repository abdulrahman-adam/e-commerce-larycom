let fromElement = document.getElementById("formServices");
let butPublicityEle = document.getElementById("butPublicity");
// console.log(fromElement);
let buttonElement = document.getElementById("annoncer");
let annulerElement = document.getElementById("annuler");

// console.log(buttonElement)
// console.log(fromElement)
buttonElement.addEventListener("click", (eo) => {
  butPublicityEle.style.opacity = 0;
  fromElement.style.opacity = 1;
});

// console.log(annulerElement)

annulerElement.addEventListener("click", (eo) => {
  fromElement.style.opacity = 0;
  butPublicityEle.style.opacity = 1;

});

// La déviation des enfants de La section du service publictaire de
// La animation du titre de la section du publicitaire

let publicitaire = document.getElementById("child");
console.log(publicitaire);
let counter1 = 1;
const autowriting2 = () => {
  const textElement2 = "Espace Publicitaire";
  publicitaire.innerText = textElement2.slice(0, counter1);
  counter1++;

  if (textElement2.length < counter1) {
    counter1 = 1;
  }
};

// const stopAutoFunction2 = setInterval(autowriting2, 1000);



// La section des enfants du espace publicitaire

let allParagraphElements = document.getElementsByClassName("child1");
// console.log(allParagraphElements)

let firstParagraphElements = 0;
let numberOfParagraphElements = allParagraphElements.length;

function leaveClassActive() {
  for (let k = 0; k < numberOfParagraphElements; k++) {
    allParagraphElements[k].classList.remove("showParagragh");
  }
}

setInterval(function () {
  firstParagraphElements++;

  if (firstParagraphElements >= numberOfParagraphElements) {
    firstParagraphElements = 0;
  }
  leaveClassActive();
  allParagraphElements[firstParagraphElements].classList.add("showParagragh");
}, 3000);

function read() {
  let childOne = document.getElementById("childOne1");
  let moreEle55 = document.getElementById("more1");
  let readEle = document.getElementById("read1");

  if (childOne.style.display === "none") {
    childOne.style.display = "inline";
    moreEle55.style.display = "none";
    readEle.innerHTML = "Affiche plus";
  } else {
    childOne.style.display = "none";
    moreEle55.style.display = "inline";
    readEle.innerHTML = "Affiche mois";
  }
}

// La section du En savoir plus 


function div22() {
  let divFirst = document.getElementById("div22");
  let moreEle22 = document.getElementById("more22");
  let enSavoirPlus22 = document.getElementById("button22");

  if (divFirst.style.display === "none") {
    divFirst.style.display = "inline";
    moreEle22.style.display = "none";
    enSavoirPlus22.innerHTML = "En savoir plus";
  } else {
    divFirst.style.display = "none";
    moreEle22.style.display = "inline";
    enSavoirPlus22.innerHTML = "En savoir mois";
  }
}



function div33() {
  let divSecond = document.getElementById("div33");
  let moreEle33 = document.getElementById("more33");
  let enSavoirPlus33 = document.getElementById("button33");

  if (divSecond.style.display === "none") {
    divSecond.style.display = "inline";
    moreEle33.style.display = "none";
    enSavoirPlus33.innerHTML = "En savoir plus";
  } else {
    divSecond.style.display = "none";
    moreEle33.style.display = "inline";
    enSavoirPlus33.innerHTML = "En savoir mois";
  }
}