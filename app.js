// Configuration de requireJS.
requirejs.config({
    baseUrl: 'lib',
    paths: {
        app: '../app'
    }
});

// On démarre notre "application" qui n'est autre qu'un simple fichier
// boostrap qui va ensuite intéragir avec les autres modules
requirejs(['app/main']);