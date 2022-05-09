define(function () {

    const leaderboardApiBaseUrl = 'https://localhost/api/v1.0';
    const module = {};

    // Définition des headers pour les requêtes vers l'API
    const headers = new Headers();
    headers.append('x-api-key', 'SPA-application');

    const show = module.show = () => {

        // On vide le tableau des score pour recalculer les scores a chaque nouveau rendu
        document
            .querySelector('.leaderboard-content')
            .innerHTML = '';

        // On va récupérer via un fetch les 10 derniers meilleurs scores
        fetch(
            `${leaderboardApiBaseUrl}/leaderboard?limit=10`,
            {
                method: 'GET',
                headers: headers,
                redirect: 'follow'
            }
        ).then(result => {
            result.json().then(json => {
                let userPosition = 1;
                json.forEach(userScore => {

                    // On va créer une ligne avec deux cellules pour accueillir les données du leaderboard
                    let leaderBoardRow = document.createElement('tr');
                    let position = document.createElement('td');
                    let usernameCell = document.createElement('td');
                    let scoreCell = document.createElement('td');
                    let dateCell = document.createElement('td');

                    // On populate la structure du DOM avec les données retournées par l'API
                    position.append(userPosition);
                    usernameCell.append(userScore.username);
                    scoreCell.append(`${userScore.score}s`);
                    dateCell.append(new Date(userScore.createdAt.date).toLocaleDateString('fr'));

                    // On rajoute toutes les cellules qu'on vient de créer à la ligne
                    leaderBoardRow.appendChild(position);
                    leaderBoardRow.appendChild(usernameCell);
                    leaderBoardRow.appendChild(scoreCell);
                    leaderBoardRow.appendChild(dateCell);

                    userPosition++;

                    // Chaque ligne est ajoutée au tableau des scores
                    document
                        .querySelector('.leaderboard-content')
                        .append(leaderBoardRow);
                });
            });
        }).catch(error => console.log('error', error));
    };

    module.register = (username, time) => {

        // On envoi le score à l'API pour le sauvegarder.
        fetch(
            `${leaderboardApiBaseUrl}/leaderboard`,
            {
                method: 'POST',
                body: JSON.stringify({
                    username: username,
                    score: time
                }),
                headers: headers,
                redirect: 'follow'
            },
        )
            .then(() => show()) // Une fois fait, on rafraîchi le tableau des scores
            .catch(error => console.log('error', error));
    };

    return module;
});