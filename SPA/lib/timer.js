define(['HTMLPartialRenderer'], function (HTMLPartialRenderer) {

    let timer = 0;
    let timerId;

    const resolve = () => {

        // Le timer est arrivé au bout, toutes les cartes n'ont pas été retourné, c'est perdu.
        // Dommage.
        if (timer === 10000) {

            // On va remplacer le board par le contenu d'un fichier HTML
            document
                .querySelectorAll('.game-run')
                .forEach((elem) => elem.classList.add('is-hidden'))

            HTMLPartialRenderer.render('.post-run-content', 'game_over');

            document
                .querySelector('.post-run')
                .classList
                .remove('is-hidden');

            // On arrête le timer pour pas que ça continue de tourner pour rien
            clearInterval(timerId);
        }

        document
            .querySelector('.memory-timer')
            .value = ++timer;
    };

    /*
    Puisqu'on fait aucun appel entre nos méthode au sein de notre module, on peut se permettre une folie :
    Exposer directement nos méthode vers l'exterieur
     */
    return {
        start: () => {
            timerId = setInterval(resolve, 1);
        },
        stop: () => {
            clearInterval(timerId);
        },
        getValue: () => {
            return timer / 100; // Le timer est en milliseconde, on repart sur des secondes.
        }
    }
})