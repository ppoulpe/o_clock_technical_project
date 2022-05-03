define(['timer'],function (timer) {

    // Je récupère dans une constante toutes mes cartes.
    // Immutable et contient tous les éléments du DOM qui ont la classe ".memory-card"
    const cards = document.querySelectorAll('.memory-card');

    // let ne sera accessible que dans ce contexte et dans les blocs enfants
    let hasFlippedCard = false;
    let lockBoard = false;
    let firstCard, secondCard;
    let doneCards = 0;

    const module = {};

    const disableCards = module.disableCards = () => {

        // En désactivant les events, les cartes désactivées ne pourront plus être retournées
        firstCard.removeEventListener('click', (e) => flipCard(e));
        secondCard.removeEventListener('click', (e) => flipCard(e));
        doneCards += 2; // On indique que 2 cartes sur 12 on été retournée.

        // Si toutes les cartes ont été retournées, c'est gagné !
        if(doneCards === 12){
            timer.stop();
            alert(`C'est gagné en ${timer.getValue()} secondes`);
        }

        // Je rend la main à l'utilisateur
        resetBoard();
    };

    const resetBoard = module.resetBoard = () => {
        // On indique qu'aucune carte n'a été retournée
        // On indique que le board n'est pas vérrouillé
        [hasFlippedCard, lockBoard] = [false, false];
        [firstCard, secondCard] = [null, null]; // les deux cartes à faire matcher sont retournées
    };

    const checkForMatch = module.checkForMatch = () => {
        let isMatch = firstCard.dataset.framework === secondCard.dataset.framework;

        // Si les deux cartes que l'utilisateur à retourné sont les mêmes : je les désactive, il marque un point
        // Si les deux cartes ne matchent pas, c'est perdu, je les retourne
        isMatch ? disableCards() : unflipCards();
    };

    const flipCard = module.flipCard = (e) => {

        if (lockBoard) return; // Si le board est vérouillé, on ne peut pas retourné de carte
        //if (this === firstCard) return; // Si on tente de retourner la même carte : "Sa MaRcHe Pas"

        // On récupère via notre évenement :
        // la target : cible sur laquelle l'utilisateur a cliqué
        // L'élément parent de la target, car on veut retourner la div qui contient l'image
        // On rajoute à cet élément la classe flip qui fait qu'on peut voir l'image. Malin.
        e.target.parentElement.classList.add('flip');

        // Si aucune carte n'a jamais été retourné, on vient de retourner notre première carte
        if (!hasFlippedCard) {
            hasFlippedCard = true;
            firstCard = e.target.parentElement;

            return;
        }

        // Sinon, c'est la seconde carte qui vient d'être retourné et on peut lancer la comparaison
        secondCard = e.target.parentElement;
        checkForMatch();
    }

    const unflipCards = module.unflipCards = () => {

        // On bloque le board, comme ça l'utilisateur ne pourra pas retourner de carte pendant 1 seconde
        // Simple mais diablement efficace pour faire perdre du temps aux try-hardeurs
        lockBoard = true;

        // Au bout d'une seconde, on rend la main à l'utilisateur, on est pas des bêtes.
        setTimeout(() => {
            firstCard.classList.remove('flip');
            secondCard.classList.remove('flip');

            resetBoard();
        }, 1000);
    }

    const init = module.init = () => {
        cards.forEach(
            card => {

                // Pour chaque carte trouvée dans le DOM, on attache l'event "click"
                // On pourra dès lors, en cliquant sur chaque carte, la retourner et vérifier si on a du flair
                // ... ou pas !
                card.addEventListener('click', (e) => flipCard(e));

                // A chaque init du board, on va mélanger les cartes
                // L'ordre visuel de chaque élément de la flexbox est définie par l'attribut "order"
                // On fait donc un random sur cette propriété pour modifier l'ordre d'affichage de chaque carte
                // https://developer.mozilla.org/fr/docs/Web/CSS/CSS_Flexible_Box_Layout
                card.style.order = Math
                    .floor(Math.random() * 12)
                    .toString();
            }
        );

        // On démarre le timer via le module "timer" injecté plus haut
        timer.start();
    }

    return module;
});