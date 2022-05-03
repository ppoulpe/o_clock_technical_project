define(function(){
    return {
        render: (selector, filename) => {
            // On va aller chercher le fichier a injecter dans le DOM
            let path = `./partials/${filename}.html`;

            // On envoi la sauce. Le innerHTML va écrasé tout le CONTENU de mon élément
            document
                .querySelector(selector)
                .innerHTML = `<object data="${path}" width="100%" height="100%">`;
        }
    }
});