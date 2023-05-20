

let i = 0;
let randomQuote = document.getElementById('clickButton');
let randomQuoteParent = document.getElementById('parentBlockquote');



randomQuote.addEventListener('click', (eo) =>{
    const randomArray = [
        ` <div id='parentBlockquote'>
        <div class="blockquote-author-image"> <img src="img/upload/casque-telephonique.jpg" width="300px" alt="L'image"></div>
        <div class='drone'>
            <h1 class="cite-last-name">Casque Téléphonique</h1>
            <p>Je remarque qu'une idéologie festive, bienveillante, collective, solidaire imprègne l'atmosphère. Et dans ce même monde règne l'agression contre la promenade, la gratuité, la conversation, la délicatesse. Je ne juge pas. Je fais comme eux.. </p>
        </div>
    </div>`,

        `<div id='parentBlockquote'>
        <div class="blockquote-author-image"> <img src="img/upload/camera.jpg" width="300px" alt="L'image"></div>

        <div class='drone'>
            <h1 class="cite-last-name">Caméra</h1>
            <p>Dans ma vie au cinéma j'ai toujours observé deux principes : ne jamais faire devant la caméra ce qu'on ne ferait pas chez soi, et ne jamais faire chez soi ce qu'on ne ferait pas devant la caméra.</p>
        </div>
    </div>`,


        ` <div id='parentBlockquote'>
        <div class="blockquote-author-image"> <img src="img/upload/lecteur.webp" width="300px" alt="L'image"></div>
        <div class='drone'>
            <h1 class="cite-last-name">Lecteur</h1>
            <p>Si jamais il lui arrivait un jour d'écrire un livre , il introduirait les personnages un à un, pour éviter aux lecteurs d'avoir à apprendre leurs noms par cœur tous à la fois.</p>
        </div>
    </div>`,

        `<div id='parentBlockquote'>
        <div class="blockquote-author-image"> <img src="img/upload/liseuse.png" width="300px" alt="L'image"></div>
        <div class='drone'>
            <h1 class="cite-last-name">Liseuse</h1>
            <p>Lorsque j'aurai terminé la lecture du dernier mot de la dernière phrase du dernier livre, je tournerai la dernière page et je déciderai seul si la vie devant moi vaut encore la peine d'être lue.</p>
        </div>
    </div>`,

        ` <div id='parentBlockquote'>
        <div class="blockquote-author-image"> <img src="img/upload/camb.jpg" width="300px" alt="L'image"></div>
        <div class='drone'>
            <h1 class="cite-last-name">Webcamb</h1>
            <p>Camera numerique qui permet de communiquer avec l’image et parfois le son par Internet.</p>
        </div>
    </div>`,

        `<div id='parentBlockquote'>
        <div class="blockquote-author-image"> <img src="img/upload/ordinateur.webp" width="300px" alt="L'image"></div>
        <div class='drone'>
            <h1 class="cite-last-name">Ordinateur</h1>
            <p>Avait comparé la mémoire au disque dur d’un ordinateur. Il s’agissait non pas de supprimer les données mais de les modifier. De transformer les souvenirs. De court-circuiter la réalité, faire naître de nouvelles images.</p>
        </div>
    </div>`,

        ` <div id='parentBlockquote'>
        <div class="blockquote-author-image"> <img src="img/upload/gps.jpg" width="300px" alt="L'image"></div>
        <div class='drone'>
            <h1 class="cite-last-name">Le GPS</h1>
            <p>Par téléphone cellulaire, ils accèdent à toutes personnes par GPS, en tous lieux par la Toile, à tout le savoir : ils hantent donc un espace topologique de voisinages, alors que nous vivions dans un espace métrique, référé par des distances.</p>
        </div>
    </div>`,

     
        ` <div id='parentBlockquote'>
        <div class="blockquote-author-image"> <img src="img/upload/microphone perfect.jpg" width="300px" alt="L'image"></div>
        <div class='drone'>
            <h1 class="cite-last-name">Microphone</h1>
            <p>La plus part des gens pensent qu’en essayer de contrôler un micro-système on détruit ce qui en fait quelque chose d’unique au monde. C’est aussi valable pour le Net.</p>
        </div>
    </div>`,

        `<div id='parentBlockquote'>
        <div class="blockquote-author-image"> <img src="img/upload/drone-professionnel.jpg" width="300px" alt="L'image"></div>
        <div class='drone'>
            <h1 class="cite-last-name">Drone-Professionnel</h1>
            <p>Avant il y avait des oiseaux, maintenant il y a des drones,  Les drones vont révolutionner les tournages</p>
        </div>
    </div>`,

    ];

   
    randomQuoteParent.innerHTML = randomArray[i];
    i++;

    if(i == randomArray.length) {
        i = 0;
    }
})