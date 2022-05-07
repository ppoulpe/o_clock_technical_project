define(['timer'], function (timer) {

    const leaderboardApiBaseUrl = 'https://localhost/api/v1.0';
    const module = {};

    // Définition des headers pour les requêtes vers l'API
    const headers = new Headers();
    headers.append('x-api-key', 'SPA-application');

    const show = module.show = () => {
        fetch(
            `${leaderboardApiBaseUrl}/leaderboard`,
            {
                method: 'GET',
                headers: headers,
                redirect: 'follow'
            }
        ).then(result => {
            result.json().then(json => {
                json.forEach(userScore => {

                    // On va créer une ligne avec deux cellules pour accueillir les données du leaderboard
                    let leaderBoardRow = document.createElement('tr');
                    let usernameCell = document.createElement('td');
                    let scoreCell = document.createElement('td');
                    let dateCell = document.createElement('td');

                    // On populate la structure du DOM avec les données retournées par l'API
                    usernameCell.append(userScore.username);
                    scoreCell.append(`${userScore.score}s`);
                    dateCell.append(new Date(userScore.createdAt.date).toLocaleDateString('fr'));

                    leaderBoardRow.appendChild(usernameCell);
                    leaderBoardRow.appendChild(scoreCell);
                    leaderBoardRow.appendChild(dateCell);

                    // On envoi les nouveaux éléments dans le tableau des scores
                    document
                        .querySelector('.leaderboard-content')
                        .append(leaderBoardRow);
                });
            });
        }).catch(error => console.log('error', error));
    };

    return module;
});