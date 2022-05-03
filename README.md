# O'Clock technical test project
Memory cards est un mini-jeu développé dans le cadre d'un entretien technique pour l'école O'Clock.

- [Découpage du projet](#decoupage_projet)
- [Single Page Application](#spa)
  - [Démarrage rapide](#spa_demarrage-rapide)
  - [Programmation modulaire](#spa_progammation_modulaire)
  - [Framework CSS](#spa_framework_css)
- [Versionning](#versionning)
- [Liens externes](#spa_lien_externe)

## <a name="decoupage_projet"></a> Découpage du projet
Le projet se décompose de la manière suivante :
* La partie Single Page Application (SPA) développé en HTML/CSS et JS Vanilla.
* La partie Application Programming Interface (API) développé en PHP8.

## <a name="spa"></a> Single Page Application
### Démarrage rapide
Le projet n'utilise aucun framework, il suffit donc de lancer le fichier index.html à la racine du projet de profiter de l'incroyable expérience vidéoludique qui s'offre à vous.

### <a name="spa_programmation_modulaire"></a> Programmation modulaire
Pour nous faciliter la vie, Require.js a été installé afin de nous permettre de faire une chose que le JS natif ne permet pas : des modules. Les modules, comparable à des classes en POO vont nous permettre de découper notre application en différentes parties, définies selon leur domaine métier.

Nous aurons donc, pour chacune des fonctionnalités de notre SPA, un module architecturé de la manière suivante :
```javascript
define(function () {
    // Je déclare mon objet module
    // Il contient toutes les méthodes à exposer
    // Il contient tous les attributs à exposer
    const module = {};
    
    // Cette méthode n'est pas assignée à mon module
    // Elle ne sera donc visible que dans ce module
    const IAmAwesome = () => {
        return "I'm awesome : ";
    };
    
    // On assigne une fonction à notre module
    // Cette méthode sera exposée vers l'exterieur
    module.hireMe = () => {
        // Je peux appeler les méthodes de mon module
        return `${IAmAwesome} Hire me!`;
    };
    
    // On retourne le module qui va nous permettre depuis l'exterieur d'intéragir avec les méthodes qu'il expose
    return module;
});
```

### <a name="spa_framework_css"></a> Framework CSS
Le CSS étant plutôt simple, nous partons sur du CSS natif avec l'emploi du framework Bulma pour la gestion du responsive (et pour avoir des éléments HTML classe sans effort).

Les cartes utilisent flex et l'emploi de Bulma est donc totalement facultatif.

## <a name="versionning"></a> Versionning
Nous utilisons la spécification _Angular_ pour le nommage des commits : https://github.com/angular/angular/blob/main/CONTRIBUTING.md#commit

Cela permet d'avoir un référentiel commun sur la bonne manière de nommer les commits. Avec des commits clairs : plus besoin de maintenir un changelog en parallèle : tout est visible et surtout **lisible** directement sur le dépôt.

## <a name="spa_lien_externe"></a> Liens externes
Documentations utiles pour comprendre le projet et retrouver les sources :
* [RequireJS](https://requirejs.org)
* [marina-ferreira](https://marina-ferreira.github.io/)