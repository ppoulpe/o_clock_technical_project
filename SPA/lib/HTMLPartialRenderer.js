define(function () {
    return {
        render: (selector, filename) => {
            // On va aller chercher le fichier a injecter dans le DOM
            let path = `./partials/${filename}.html`;

            // On va lancer une requête AJAX qui va récupérer le contenu HTML
            // On injecte ensuite ce contenu dans le selecteur voulu
            fetch(path).then(
                response => {
                    response.text().then(
                        html => document
                            .querySelector(selector)
                            .innerHTML = html
                    )
                });
        }
    }
});