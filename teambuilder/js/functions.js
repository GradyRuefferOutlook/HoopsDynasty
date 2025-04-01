function fetchTeams(username) {
    let params = "username=" + encodeURIComponent(username);

    fetch("../teambuilder/queries/getteams.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params
    })
        .then(response => response.json())
        .then(data => {
            if (data.status !== "NONE") {
                data.forEach(team => {
                    addTeamDropdown(team.team_name, team.center, team.power_forward, team.small_forward, team.point_guard, team.shooting_guard);
                });
            }
        })
}

async function getCreator() {
    const response = await fetch("../teambuilder/queries/getusername.php");
    const data = await response.json();
    return data.username || null;
}

function fetchUserTeams() {
    fetch("../teambuilder/queries/getusername.php")
        .then(response => response.json())
        .then(data => {
            if (data.username) {
                fetchTeams(data.username);
            }
        });
}

fetchUserTeams();

function togglePositions(element) {
    const positions = element.nextElementSibling;
    positions.style.display = positions.style.display === "none" ? "block" : "none";
}

function assignPlayer(button) {
    if (storedPlayer) {
        button.querySelector("span").textContent = storedPlayer;
    }
}

async function saveTeam(button) {
    const teamContainer = button.closest('.dropdown-container');
    const teamNameInput = teamContainer.querySelector('.team-name-input');
    const positionButtons = teamContainer.querySelectorAll('.position-buttons button');

    const teamName = teamNameInput.value;

    const creator = await getCreator();

    let formData = new FormData();
    formData.append("creator", creator);
    formData.append("team_name", teamName);
    formData.append("center", positionButtons[0].querySelector('span').textContent.trim());
    formData.append("power_forward", positionButtons[1].querySelector('span').textContent.trim());
    formData.append("small_forward", positionButtons[2].querySelector('span').textContent.trim());
    formData.append("point_guard", positionButtons[3].querySelector('span').textContent.trim());
    formData.append("shooting_guard", positionButtons[4].querySelector('span').textContent.trim());

    fetch("../teambuilder/queries/saveteam.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                button.style.backgroundColor = "lightGreen";
            }
            else {
                button.style.backgroundColor = "red";
            }
        })
}

function deleteTeam(button) {
    const teamContainer = button.closest('.dropdown-container');
    const teamNameInput = teamContainer.querySelector('.team-name-input');
    const teamName = teamNameInput.value;

    if (!teamName || teamName === "N/A") {
        button.style.backgroundColor = "red";
        return;
    }

    let params = new URLSearchParams({ team_name: teamName });
    fetch("../teambuilder/queries/deleteteam.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                teamContainer.remove();
            }
        })
}

function addTeamDropdown(team_name, center, power_forward, small_forward, point_guard, shooting_guard, defined = true) {
    const container = document.getElementById("team-section");
    const newDropdown = document.createElement("div");
    newDropdown.classList.add("dropdown-container");

    if (defined) {
        newDropdown.innerHTML = `
        <input type="text" disabled class="team-name-input" value="${team_name || "N/A"}">
        <button class="team-dropdown" onclick="togglePositions(this)">Toggle Positions</button>
        <div class="position-buttons" style="display: none;">
            <button onclick="assignPlayer(this)">Center: <span>${center || "N/A"}</span></button>
            <button onclick="assignPlayer(this)">Power Forward: <span>${power_forward || "N/A"}</span></button>
            <button onclick="assignPlayer(this)">Small Forward: <span>${small_forward || "N/A"}</span></button>
            <button onclick="assignPlayer(this)">Point Guard: <span>${point_guard || "N/A"}</span></button>
            <button onclick="assignPlayer(this)">Shooting Guard: <span>${shooting_guard || "N/A"}</span></button>
            <button onclick="saveTeam(this)">:Save Team:</button>
            <button onclick="deleteTeam(this)">:Delete Team:</button>
        </div>
    `;
    }
    else {
        newDropdown.innerHTML = `
        <input type="text" class="team-name-input" value="${team_name || "N/A"}">
        <button class="team-dropdown" onclick="togglePositions(this)">Toggle Positions</button>
        <div class="position-buttons" style="display: none;">
            <button onclick="assignPlayer(this)">Center: <span>${center || "N/A"}</span></button>
            <button onclick="assignPlayer(this)">Power Forward: <span>${power_forward || "N/A"}</span></button>
            <button onclick="assignPlayer(this)">Small Forward: <span>${small_forward || "N/A"}</span></button>
            <button onclick="assignPlayer(this)">Point Guard: <span>${point_guard || "N/A"}</span></button>
            <button onclick="assignPlayer(this)">Shooting Guard: <span>${shooting_guard || "N/A"}</span></button>
            <button onclick="saveTeam(this)">:Save Team:</button>
            <button onclick="deleteTeam(this)">:Delete Team:</button>
        </div>
    `;
    }

    container.appendChild(newDropdown);
}

document.getElementById("add_team_button").addEventListener("click", function (event) {
    addTeamDropdown("New Team", "", "", "", "", "", false);
})

let storedPlayer = "";

let storePlayer = function (value) {
    let [name, team] = value.split(" | ");
    let params = "name=" + name + "&team=" + team;

    let config = {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params
    };

    fetch("../teambuilder/queries/getspecifiedplayer.php", config)
        .then(response => response.json())
        .then(data => {
            if (data.status !== "NONE") {
                storedPlayer = data.player_name; // Store the player's name directly
                document.getElementById("player_photo").src = "data:image/jpeg;base64," + data.photo_base64;
                document.getElementById("player_name").innerHTML = data.player_name + "<br>" + data.player_team;
                document.getElementById("player_stats").innerHTML
                    = "Player Stats:" +
                    "<br>Three Point: " + data.three_point_percentage +
                    "%<br>Two Point: " + data.two_point_percentage +
                    "%<br>Blocks: " + data.blocks_per_game +
                    "<br>Steals: " + data.steals_per_game +
                    "<br>Fouls: " + data.personal_fouls_per_game;
            }
        })
}

storePlayer("Lebron James | LA Lakers");

let getPlayers = function (name, team) {
    let queriedPlayers = [];
    let params;
    if (name === "" && team !== "") {
        params = "team=" + team;
    }
    else if (team === "" && name !== "") {
        params = "name=" + name;
    }
    else if (name !== "" && team !== "") {
        params = "name=" + name + "&team=" + team;
    }

    let config = {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params
    };

    fetch("../teambuilder/queries/getplayers.php", config)
        .then(response => response.json())
        .then(data => {
            data.forEach(player => {
                queriedPlayers.push(player)
            });

            let none = document.getElementById("none_found");
            let container = document.getElementById("player_list");
            container.innerHTML = "";

            if (queriedPlayers[0] === "NONE" || queriedPlayers.length === 0) {
                none.style["display"] = "block";
            }
            else {
                none.style["display"] = "none";

                queriedPlayers.forEach(player => {
                    let button = document.createElement("button");
                    button.textContent = `${player.player_name} | ${player.player_team}`;
                    button.classList.add("player-button");

                    button.addEventListener("click", function () {
                        storePlayer(button.textContent);
                    });

                    container.appendChild(button);
                })
                container = document.getElementById("team-section");
            }
        })
}

let nameInput = document.getElementById("name_search");
let teamInput = document.getElementById("team_search");

nameInput.addEventListener("input", function (event) {
    getPlayers(nameInput.value, teamInput.value);
})

teamInput.addEventListener("input", function (event) {
    getPlayers(nameInput.value, teamInput.value);
})

getPlayers("", "");