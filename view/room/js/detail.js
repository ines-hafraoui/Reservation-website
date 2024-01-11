"use strict";
// LANCER GENERATION DE LA PAGE
findRoom();

// CREATION DE LA VARIABLE DATE
function getCurrentDateTime() {
    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = ('0' + (currentDate.getMonth() + 1)).slice(-2); // Les mois commencent à partir de 0, donc on ajoute 1 et on formate sur deux chiffres
    var day = ('0' + currentDate.getDate()).slice(-2); // Formater le jour sur deux chiffres
    var hours = ('0' + currentDate.getHours()).slice(-2); // Formater les heures sur deux chiffres
    var minutes = ('0' + currentDate.getMinutes()).slice(-2); // Formater les minutes sur deux chiffres
    var seconds = ('0' + currentDate.getSeconds()).slice(-2); // Formater les secondes sur deux chiffres

    var formattedDateTime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
    return formattedDateTime;
}

var currentDateTime = getCurrentDateTime();
console.log(currentDateTime);

//TOGGLE VARIABLE
let displayName = false;
let displayAdd = false;
let displayDelete = false;

// DEFINITION DES ELEMENTS HTML EN VARIABLE (pour pouvoir les modifier)
let nameRoom = document.getElementById('nameRoom')
let listMat = document.getElementById('listMat')
let historique = document.getElementById('historique')
let statut = document.getElementById('statut')


let changeName = document.getElementById('changeName')
let formName = document.getElementById('formName')
let newName = document.getElementById('newName')
let validateName = document.getElementById('validateName')

let addMat = document.getElementById('addMat')
let formAdd = document.getElementById('formAdd')
let newMat = document.getElementById('newMat')
let validateAddMat = document.getElementById('validateAddMat')

let deleteMat = document.getElementById('deleteMat')
let formDelete = document.getElementById('formDelete')
let oldMat = document.getElementById('oldMat')
let validateDeleteMat = document.getElementById('validateDeleteMat')


// FONCTIONS SERVANT A REMPLIR LE HTML AVEC LES BONNES INFORMATIONS
function update_infosRoom(dataRoom){
    nameRoom.innerHTML = ``;
    nameRoom.insertAdjacentHTML("beforeend",
        `${dataRoom.name_room}`)
    // image.innerHTML = ``;
    // image.insertAdjacentHTML("beforeend",
    //     `<img src="">`)

}
function update_historiqueRes(data){
    data.forEach(elt => {
        historique.insertAdjacentHTML("afterbegin",
            `<tr>
                <td><a href="../reservation/detail.php?id_res=${elt.id_res}">${elt.id_res}</a></td>
                <td><a href="../user/detail.php?login=${elt.login}">${elt.login}</a></td>
                <td>${elt.date_begin}</td>
                <td>${elt.date_end}</td>
                <td>${elt.date_return}</td>
            </tr>`
        )
    })
}
function update_statutMateriel(data) {
    data.forEach(elt => {
        if (currentDateTime > elt.date_begin && elt.date_return === null) {
            statut.innerHTML = ``;
            statut.insertAdjacentHTML("beforeend",
                `La salle est actuellement occupée par <a href="../user/detail.php?login=${elt.login}">${elt.login}</a> jusqu'à ${elt.date_end.substr(10)}.`);

        }
        else {
            statut.innerHTML = ``;
            statut.insertAdjacentHTML("beforeend",
                `La salle est libre`);
        }
    })
}
function update_listMat(data) {
    const url = new URL(window.location.href);
    const id_room = url.searchParams.get("id_room");
    data.forEach(elt => {
        console.log(elt.id_room, id_room)
        if (elt.id_room == id_room){
            listMat.insertAdjacentHTML("afterbegin",
                `<tr>
                <td><a href="../material/detail.php?id_mat=${elt.id_material}">${elt.id_material}</a></td>
                <td><a href="../model/detail.php?id_model=${elt.id_model}">${elt.name_model}</a></td>
                <td>${elt.number}</td>
                <td>${elt.description_material}</td>
            </tr>`
            )
        }
    })
}

// FONCTIONS SERVANT A CHANGER LES INFORMATIONS

//changement des display
changeName.onclick = function() {
    if (displayName == true){
        formName.style.display = 'none';
        displayName = false;
    } else {
        formName.style.display = 'block';
        displayName = true;
    }
};
addMat.onclick = function() {
    if (displayAdd == true){
        formAdd.style.display = 'none';
        displayAdd = false;
    } else {
        formAdd.style.display = 'block';
        displayAdd = true;
    }
};
deleteMat.onclick = function() {
    if (displayDelete == true){
        formDelete.style.display = 'none';
        displayDelete = false;
    } else {
        formDelete.style.display = 'block';
        displayDelete = true;
    }
};

//gère les données rentrées par les admins
function mat_uCanAdd(data){
    const url = new URL(window.location.href);
    const id_room = url.searchParams.get("id_room");
    let html = ``;
    data.forEach(elt => {
        if (elt.id_room != id_room) {
            html += `<option value="${elt.id_material}">${elt.name_model} N°${elt.number}</option>`;
        }
    })
    console.log(data);
    newMat.insertAdjacentHTML("beforeend", html);
    console.log('non');
}
function mat_uCanDelete(data){
    const url = new URL(window.location.href);
    const id_room = url.searchParams.get("id_room");
    let html = ``;
    data.forEach(elt => {
        if (elt.id_room == id_room) {
            html += `<option value="${elt.id_material}">${elt.name_model} N°${elt.number}</option>`;
            console.log(html)
        }
    })
    console.log(data);
    oldMat.insertAdjacentHTML("beforeend", html);
    console.log('non');
}

validateAddMat.onclick = function (){
    const url = new URL(window.location.href);
    const id_room = url.searchParams.get("id_room");
    let mat = document.getElementById('newMat').value;
    updateInfo(mat, id_room);
}
validateDeleteMat.onclick = function (){
    let mat = document.getElementById('oldMat').value;
    let id_room = 'null';
    updateInfo(mat, id_room);
}
validateName.onclick = function (){
    let nameRoom = document.getElementById('newName').value;
    updateRoom(nameRoom);
}

// FONCTIONS SERVANT A FAIRE DES REQUETES A L'API
// list
function findRoom(){
    const url = new URL(window.location.href);
    const id_room = url.searchParams.get("id_room");
    const payload = {
        'id_room' : id_room,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/room/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data[0];
            findReservation(data);
            findMat();
            return update_infosRoom(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function findReservation(data){
    const url = new URL(window.location.href);
    const id_room = url.searchParams.get("id_room");
    console.log(data.id_room);
    const payload = {
        "id_room" : id_room,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/reservation/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data;
            console.log(data);
            update_historiqueRes(data);
            return update_statutMateriel(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function findMat(){
    const payload = {
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/material/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data;
            console.log('coucou', data);
            mat_uCanAdd(data);
            mat_uCanDelete(data);
            return update_listMat(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
//update
function updateInfo(mat , id_room) {
    const payload = {
        'id_material': mat,
        id_room : id_room
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/material/update'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            window.location.reload();
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function updateRoom(nameRoom){
    const url = new URL(window.location.href);
    const id_room = url.searchParams.get("id_room");
    const payload = {
        "id_room" : id_room,
        "name_room" : nameRoom
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/room/update'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            window.location.reload();
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}