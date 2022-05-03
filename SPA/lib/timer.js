define(function () {

    let timer = 0;
    let timerId;
    const module = {};

    const resolve = () => {
        if (timer === 10000) {

            // On va remplacer le board par le contenu d'un fichier HTML
            // la balise object va nous permettre d'inclure un code HTML
            document
                .querySelector('.memory-game')
                .innerHTML = '<object data="./partials/game_over.html" width="100%" height="100%">';

            clearInterval(timerId);
        }

        document
            .getElementsByClassName('memory-timer')
            .item(0)
            .value = timer++;
    };

    const start = module.start = () => {
        timerId = setInterval(resolve, 1);
    }

    const stop = module.stop = () => {
        clearInterval(timerId);
    };

    const getValue = module.getValue = () => {
        return timer / 100;
    };

    return module;
})