define(['require', 'cards', 'leaderboard'], function (require, cardsModule, leaderboard) {

    // Lorsqu'on clique sur "jouer", on démarre une nouvelle partie
    document
        .querySelector('.start')
        .addEventListener('click', () => {
            cardsModule.init();

        });

    // On affiche le leaderboard
    leaderboard.show();
    
});