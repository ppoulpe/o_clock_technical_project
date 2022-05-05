# O'Clock technical test project
Memory cards est un mini-jeu développé dans le cadre d'un entretien technique pour l'école O'Clock.

- [Découpage du projet](#decoupage_projet)
- [Single Page Application (SPA)](#spa)
  - [Démarrage rapide](#spa_demarrage-rapide)
  - [Programmation modulaire](#spa_progammation_modulaire)
  - [Framework CSS](#spa_framework_css)
- [Application Programming Interface (API)](#api)
  - [Démarrage rapide](#api_demarrage_rapide) 
  - [Tests](#api_tests) 
  - [Commandes disponibles](#api_commands) 
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

## <a name="api"></a> Application Programming Interface
### <a name="api_prerequise"></a> Prérequis
L'API nécessite les composants suivants :
* [Docker](https://docs.docker.com/get-started/)
* [docker-compose](https://docs.docker.com/compose/gettingstarted/)
* [Make](http://gnuwin32.sourceforge.net/packages/make.htm)

### <a name="api_demarrage_rapide"></a> Démarrage rapide
Pour démarrer l'API :
1. Se rendre dans le dossier `API`.
2. Lancer la commande `make up && make install` qui va construire et démarrer les containers puis installer le projet.
3. Se rendre sur l'URL [https://localhost/api/doc](https://localhost/api/doc) pour consulter la documentation de l'API.

### <a name="api_tests"></a> Tests
L'API est testée fonctionnellement via PHPUnit, le rapport de couverture de code est généré via Pcov et les fixtures sont générées via Doctrine.
* Les tests se lancent via la commande `make phpunit`
* Le rapport de couverture de code se situe dans le dossier suivant : `API/build/coverage` 

### <a name="api_commands"></a> Commandes disponibles
| Commande             | Description                                                                                         |
|----------------------|-----------------------------------------------------------------------------------------------------|
| `make start`         | Démarre tous les containers existants.                                                              |
| `make stop`          | Stop tous les containers existants.                                                                 |
| `make up`            | Construit et démarre tous les containers.                                                           |
| `make up-with-build` | Force la construction et démarre tous les containers.                                               |
| `make bash`          | Lance un bash sur le container PHP. <br/> A utiliser pour installer des dépendances via `composer`. |
| `make phpunit`       | Execute tous les tests et génère la couverture de code.                                             |
| `make install`       | Installe le projet (dépendances composer, base local et base de test)                               |
| `make cs-fixer`      | Corrige les fichiers via cs-fixer (code style)                                                      |
| `make phpstan`       | Lance une analyse de code                                                                           |

Pour en savoir plus : [Les tests dans Symfony](https://symfony.com/doc/current/testing.html), [Fixtures](https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html)

## <a name="versionning"></a> Versionning
Nous utilisons la spécification _Angular_ pour le nommage des commits : https://github.com/angular/angular/blob/main/CONTRIBUTING.md#commit

Cela permet d'avoir un référentiel commun sur la bonne manière de nommer les commits. Avec des commits clairs : plus besoin de maintenir un changelog en parallèle : tout est visible et surtout **lisible** directement sur le dépôt.

## <a name="spa_lien_externe"></a> Liens externes
Documentations utiles pour comprendre le projet et retrouver les sources :
* [RequireJS](https://requirejs.org)
* [marina-ferreira](https://marina-ferreira.github.io/)