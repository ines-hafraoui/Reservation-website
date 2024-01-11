"use strict";
console.log(donneesSession.id_role);
const searchBox = document.getElementById('search-box');    // Champ de recherche
const searchBtn = document.getElementById('search-btn');    // Bouton "chercher"
const user_list = document.querySelector('#user-list>ul');           // L'emplacement de la liste
const role_list = document.querySelector('#user-list>aside');           // L'emplacement de la liste
let user_data = {};
let role_data = {};
let checkBoxes= [];
let searchInput;


// console.log(user_list);
window.addEventListener('load', roleGet);

//Traitement des données de role
function roleGet() {
    //définition des variables
    // var url = new URL(window.location.href);
    var payload = {};

    APIcallPOST('https://asaed4.gremmi.fr/api/role/list', payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            role_data =JSON.parse(response);
            // console.log(role_data);
            handleRoleData(role_data.data);
            userGet();
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function handleRoleData(results) {
    // console.log(results)
    // removeAllChildNodes(user_list);
    results.forEach(r => {
        // console.log(r.name_role);
        let html = `
                <div>
                    <input type="checkbox" id="${r.id_role}" name="role">
                    <label for="role">${r.name_role}</label>
                </div>
`;
        role_list.insertAdjacentHTML('beforeend', html);
    })


    // Gestion des filtres
    checkBoxes = document.querySelectorAll("[type=checkbox][name=role]");
    console.log(checkBoxes);
    checkBoxes.forEach(checkbox=> {
        checkbox.addEventListener('change', filtreUsers);
    });
}

//Traitement des données utilisateurs
function userGet() {
    //définition des variables
    // var url = new URL(window.location.href);
    var payload = {};
    // console.log(JSON.stringify(payload));
    APIcallPOST('https://asaed4.gremmi.fr/api/user/list', payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            user_data =JSON.parse(response);
            CompleteUserData(user_data.data, role_data.data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function CompleteUserData(results, roles) {
    // console.log(roles)

    removeAllChildNodes(user_list);
    results.forEach(r => {
        // console.log(r.first_name);
        let html = `<a href="detail.php?login=${r.login}">
                    <li id="${r.login}">
                        <img src="../../../img/utilisateur.png" alt="icon profil utilisateur">
                        <div><h3>${r.name} ${r.first_name}</h3>
`;
        roles.forEach(role => {
            if(role.id_role === r.id_role){
                // console.log(role.name_role);
                html += `<p class="${role.id_role}">${role.name_role}</p></div>
                </li></a>
                `;
            }
        })
        user_list.insertAdjacentHTML('beforeend', html);
    })

    searchInput = document.getElementById('user-search');
    searchUser();
}


//Gestion des Filtres
function filtreUsers(){
    let critereFiltre = [];
    // console.log(checkBoxes);
    checkBoxes.forEach(checkbox => {
        console.log(checkbox);
        if (checkbox.checked){
            critereFiltre.push(checkbox.id)
        }
    })
    console.log(critereFiltre);

    if (critereFiltre.length>0){
        console.log('on filtre sur le crière suivant : ' + critereFiltre.toString());
        let filterResults = [];
        let filteredResults = [];
        critereFiltre.forEach(c => {
            filterResults.push(user_data.data.filter(user=> c.includes(user.id_role)));
        })
        filterResults.forEach(res => {
            res.forEach(r => { filteredResults.push(r);})
        })

        console.log(filteredResults);
        // console.log(filterResults);
        CompleteUserData(filteredResults, role_data.data);
    }
    else{
        console.log('pas de filtre sélectionné, on affiche tout')
        CompleteUserData(user_data.data, role_data.data);
    }
}

//GESTION DE LA RECHERCHE UTILISATEUR
function searchUser() {
    const filterUsers = () => {
        const searchTerm = searchInput.value.trim().toLowerCase();
        const userList = document.querySelector('.userdisplay');
        const users = Array.from(userList.getElementsByTagName('li'));

        users.forEach(user => {
            const userName = user.querySelector('h3').textContent.toLowerCase();
            if (userName.includes(searchTerm)) {
                user.style.display = 'flex';
            } else {
                user.style.display = 'none';
            }
        });
    };

    searchInput.addEventListener('input', filterUsers);
}
