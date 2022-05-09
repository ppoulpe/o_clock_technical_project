# O'Clock technical test project
Memory cards est un mini-jeu développé dans le cadre d'un entretien technique pour l'école O'Clock.

- [Découpage du projet](#decoupage_projet)
- [Single Page Application (SPA)](#spa)
  - [Démarrage rapide](#spa_demarrage-rapide)
  - [Programmation modulaire](#spa_progammation_modulaire)
  - [Framework CSS](#spa_framework_css)
- [Application Programming Interface (API)](#api)
  - [Démarrage rapide](#api_demarrage_rapide) 
  - [Architecture MVC](#api_architecture) 
  - [Documentation](#api_documentation) 
  - [Qualité du code](#api_quality_tools) 
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
Le projet n'utilise aucun framework, il est donc possible de le lancer directement via un server HTTP basique : `make up` ou `docker-compose up -d` depuis la racine SPA.

### <a name="spa_programmation_modulaire"></a> Programmation modulaire
Pour nous faciliter la vie, Require.js a été installé afin de nous permettre de faire une chose que le JS natif ne permet pas : des modules. Les modules, comparable à des classes en POO vont nous permettre de découper notre application en différentes parties, définies selon leur domaine métier.

Nous aurons donc, pour chacune des fonctionnalités de notre SPA, un module architecturé de la manière suivante :
```javascript
define(function () {
    // On déclare notre objet module
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
        // On peut appeler les méthodes de notre module
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

### <a name="api_architecture"></a> Architecture MVC
Le projet utilise une architecture MVC (Model View Controller) classique. Quelques nuances apportées :
* Les controllers n'executent aucune logique métier. Ils récupère une requête, passe cette requête aux services concernés et retourne le résultat de ces services sous forme de réponse.
* L'API n'expose jamais ses entités vers l'exterieur. Nous utilisons des DTO (Data Transfert Object) pour n'exposer que les données que nous estimons sûres et pertinentes. Les entités ne sortent jamais vers l'extérieur directement.
* La logique métier est implémentée dans des services dédiés (Validation, Gestion du leaderboard). Les repositories bien qu'étant des services sont considérés comme "à part" et jamais appelé directement via les controllers pour éviter une fuite maladroite des données de la base vers l'exterieur sans contrôle.

### <a name="api_documentation"></a> Documentation API
En plus de cette documentation à destination des développeurs, nous avons mis en place une documentation plus fonctionnelle, utilisant la spécification OpenAPI. 
La documentation se trouve sur l'URL suivante : [https://localhost/api/doc](https://localhost/api/doc)

La documentation existe aussi au format JSON afin d'être importable dans des outils tels que Postman : [https://localhost/api/doc.json](https://localhost/api/doc.json)

### <a name="api_code_quality"></a> Qualité de code
Le projet respecte les standards PSR. Pour vérifier la qualitée générale du projet, `PHPStan` et `CS-Fixer` ont été utilisé. 
Pour utiliser ces deux outils : 
* `make cs-fixer` 
* `make phpstan` 

### <a name="api_tests"></a> Tests
L'API est testée fonctionnellement via PHPUnit, le rapport de couverture de code est généré via Pcov et les fixtures sont générées via Doctrine.
* Les tests se lancent via la commande `make phpunit`
* Le rapport de couverture de code se situe dans le dossier suivant : `API/build/coverage` 

### <a name="api_commands"></a> Commandes disponibles
Le projet utilise `Make` pour permettre l'utilisation de commandes simplifiées. Les commandes se lancent depuis la racine du projet (ici, `API`) :

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
* [Open API](https://spec.openapis.org/oas/v3.1.0)
* [Symfony](https://symfony.com/doc/current/index.html)

## <a name="do_more"></a> Aller plus loin
Le projet a été développé dans le cadre d'un test technique. On a donc essayé de couvrir le plus de technos et bonnes pratiques possibles. Il est bien entendu possible de faire mieux et plus. Voici quelques pistes d'améliorations :
* Utiliser un fichier .env pour rendre les url de la SPA dynamique en fonction des environnements
* Executer les outils de qualité de code (phpstan et cs-fixer) et les tests unitaires dans la CI (COntinuous Integration) github
* Faire en sorte d'écraser le score d'un utilisateur existant dans le projet API. Ajourd'hui, tous les scores sont enregistrés en cas de victoire
* Utiliser la déléguation d'événements JS pour découper le projet SPA en plusieurs blocs HTML. Aujourd'hui nous avons utilisé quelques tips pour rendre notre SPA dynamique mais elle n'est pas assez bien découpé car l'utilisation d'AJAX compléxifie la gestion des événéments.
