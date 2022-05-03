define(['SPA/lib/timer'],function (timer) {

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
        firstCard.removeEventListener('click', (e) => flipCard(e));
        secondCard.removeEventListener('click', (e) => flipCard(e));
        doneCards += 2; // On indique que 2 cartes sur 12 on été retournée.

        if(doneCards === 12){
            timer.stop();
            alert(`C'est gagné en ${timer.getValue()} secondes`);
        }

        resetBoard();
    };

    const resetBoard = module.resetBoard = () => {
        [hasFlippedCard, lockBoard] = [false, false];
        [firstCard, secondCard] = [null, null];
    };

    const checkForMatch = module.checkForMatch = () => {
        let isMatch = firstCard.dataset.framework === secondCard.dataset.framework;

        isMatch ? disableCards() : unflipCards();
    };

    const flipCard = module.flipCard = (e) => {

        if (lockBoard) return;
        if (this === firstCard) return;

        e.target.parentElement.classList.add('flip');

        if (!hasFlippedCard) {
            hasFlippedCard = true;
            firstCard = e.target.parentElement;

            return;
        }

        secondCard = e.target.parentElement;
        checkForMatch();
    }

    const unflipCards = module.unflipCards = () => {
        lockBoard = true;

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