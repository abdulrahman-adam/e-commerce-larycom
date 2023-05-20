
// La section de contactReseau

let emailElement = document.querySelector(".emailElement");
let telElement = document.querySelector(".telephoneElement");
let locationElement = document.querySelector(".locationElement");

let disparu1Element = document.querySelector(".disparu1");
let disparu2Element = document.querySelector(".disparu2");
let disparu3Element = document.querySelector(".disparu3");

retournerElement1 = document.querySelector(".retournerContact1");
retournerElement2 = document.querySelector(".retournerContact2");
retournerElement3 = document.querySelector(".retournerContact3");


emailElement.addEventListener("click", (eo) => {
  disparu1Element.style.display = "block";
});

retournerElement1.addEventListener("click", (eo) => {
    disparu1Element.style.display = "none";
  });




telElement.addEventListener("click", (eo) => {
  disparu2Element.style.display = "block";
});

retournerElement2.addEventListener("click", (eo) => {
    disparu2Element.style.display = "none";
  });




locationElement.addEventListener("click", (eo) => {
  disparu3Element.style.display = "block";
});

retournerElement3.addEventListener("click", (eo) => {
    disparu3Element.style.display = "none";
  });

