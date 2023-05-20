let allPlus = document.querySelectorAll('.plus');
// console.log(allPlus);


allPlus.forEach(item =>{
    item.addEventListener('click', (eo) =>{
    let contentElement =  eo.target.parentElement.parentElement.getElementsByClassName('content')[0];
        contentElement.classList.toggle("active");

        if(contentElement.classList.contains("active")){
            contentElement.style.height = `${contentElement.scrollHeight}px`;
        } else {
            contentElement.style.height = `0`;

        }

        // pour changemet le symple "+"
        item.classList.toggle('hide-plus');
      


        // le changement entre les symples "+" et '__'
        if(item.classList.contains("hide-plus")) {
            item.innerText = "__";
            item.style.transform = "translateY(-22px)"
        } else {
            item.innerText = "+";
            item.style.transform = "translateY(0)"
        }
    })
})