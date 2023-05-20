




function lire() {
    let firstSpanElement = document.querySelector('.firstSpan');
    let secondSpanElement = document.querySelector('.secondSpan');
    let readEle7 = document.getElementById("lire");
  
    if (firstSpanElement.style.display === "none") {
      firstSpanElement.style.display = "inline";
      secondSpanElement.style.display = "none";
      readEle7.innerHTML = "Affiche plus";
    } else {
      firstSpanElement.style.display = "none";
      secondSpanElement.style.display = "inline";
      readEle7.innerHTML = "Affiche mois";
    }
  }