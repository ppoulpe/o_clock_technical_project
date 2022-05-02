define(function () {

    // Je récupère dans une constante toutes mes cartes.
    // Immutable et contient tous les éléments du DOM qui ont la classe ".memory-card"
    const cards = document.querySelectorAll('.memory-card');

    // let ne sera accessible que dans ce contexte et dans les blocs enfants
    let hasFlippedCard = false;
    let lockBoard = false;
    let firstCard, secondCard;

    const module = {};

    const disableCards = module.disableCards = () => {
        firstCard.removeEventListener('click', (e) => flipCard(e));
        secondCard.removeEventListener('click', (e) => flipCard(e));

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

    const getAll = module.getALl = () => {
        return document.querySelectorAll('.memory-card');
    }

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

    const shuffle = module.shuffle = () => {
        cards.forEach(card => {
            card.style.order = Math
                .floor(Math.random() * 12)
                .toString();
        });
    }

    const init = module.init = () => {
        cards.forEach(
            card => card.addEventListener('click', (e) => flipCard(e))
        );
        shuffle();
    }

    return module;
});