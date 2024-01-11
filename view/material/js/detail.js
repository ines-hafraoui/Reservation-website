"use strict";
// LANCER GENERATION DE LA PAGE
findMaterial();

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
let displayDateAdd = false;
let displayDesc = false;
let displayEtat = false;
let displayPrblm = false;

// DEFINITION DES ELEMENTS HTML EN VARIABLE (pour pouvoir les modifier)
let nameModele = document.getElementById('nameModele')
let numMaterial = document.getElementById('numMaterial')
let desc = document.getElementById('desc')
let ajout = document.getElementById('ajout')
let statut = document.getElementById('statut')
let prblm = document.getElementById('prblm')
let image = document.getElementById('image')
let etat = document.getElementById('etat')
let historique = document.getElementById('historique')
let changeDateAdd = document.getElementById('changeDateAdd')
let formDateAdd = document.getElementById('formDateAdd')
let validateDateAdd = document.getElementById('validateDateAdd')
let changeDesc = document.getElementById('changeDesc')
let formDesc = document.getElementById('formDesc')
let validateDesc = document.getElementById('validateDesc')
let changeEtat = document.getElementById('changeEtat')
let formEtat = document.getElementById('formEtat')
let validateEtat = document.getElementById('validateEtat')
let changePrblm = document.getElementById('changePrblm')
let formPrblm = document.getElementById('formPrblm')
let validatePrblm = document.getElementById('validatePrblm')
let formRoom = document.getElementById('formRoom')
let newRoom = document.getElementById('newRoom')
let validateRoom = document.getElementById('validateRoom')

// FONCTIONS SERVANT A REMPLIR LE HTML AVEC LES BONNES INFORMATIONS
function update_infosModele(dataModel){
    nameModele.innerHTML = ``;
    nameModele.insertAdjacentHTML("beforeend",
        `<a href="../model/detail.php?id_model=${dataModel.id_model}">${dataModel.name_model}</a>`)
    // image.innerHTML = ``;
    // image.insertAdjacentHTML("beforeend",
    //     `<img src="">`)
}
function update_infosMateriel(dataMat){
    numMaterial.innerHTML = ``;
    numMaterial.insertAdjacentHTML("beforeend",
        `${dataMat.number}`);
    ajout.innerHTML = ``;
    ajout.insertAdjacentHTML("beforeend",
        `${dataMat.date_add}`);
    etat.innerHTML = ``;
    etat.insertAdjacentHTML("beforeend",
        `${etatMateriel(dataMat)}`);
    if (dataMat.description_material === null){
        desc.innerHTML = ``;
    } else {
        desc.innerHTML = ``;
        desc.insertAdjacentHTML("beforeend",
            `${dataMat.description_material}`);
    }
}
function etatMateriel(data){

    if(data.obsolete === 1){
        return `Materiel obsolète.`;
    } else if (data.in_repair === 1){
        return 'Materiel en réparation.';
    } else if (data.id_room !== null){
        findRoom(data);
    } else {
        return 'Le materiel est disponible pour les réservations.';
    }
}
function update_inRoom(data){
    etat.innerHTML = ``;
    etat.insertAdjacentHTML("beforeend",
        `Le materiel se situe dans : ${data.name_room}`);
}
function update_infosProblem(dataPrblm){
    if (dataPrblm.length === 0){
        prblm.innerHTML = ``;
        prblm.insertAdjacentHTML("beforeend",
            `Il n'y a pas de problème enregistré concernant ce matériel.`);
    } else {
        prblm.innerHTML = ``;
        dataPrblm.forEach(elt => {
            prblm.insertAdjacentHTML("beforeend",
                `<li> ${elt.problem_desc} </li>`)
        })
    }
}
function update_statutMateriel(data){
    if (etat.firstChild.textContent === "Le materiel est disponible pour les réservations."){
        data.forEach(elt => {
            if (currentDateTime > elt.date_begin && elt.date_return === null){
                if (elt.date_end < currentDateTime){
                    statut.innerHTML = ``;
                    statut.insertAdjacentHTML("beforeend",
                        `Le materiel est actuellement retenu par <a href="../user/detail.php?login=${elt.login}">${elt.login}</a>. Il devait être rendu le ${elt.date_end.substr(0,10)}.`);
                } else {
                    statut.innerHTML = ``;
                    statut.insertAdjacentHTML("beforeend",
                        `Le materiel est actuellement reservé par <a href="../user/detail.php?login=${elt.login}">${elt.login}</a> jusqu'au ${elt.date_end.substr(0,10)}.`);
                }
            }
            else {
                statut.innerHTML = ``;
                statut.insertAdjacentHTML("beforeend",
                    `Le materiel est en stock.`);
            }
        })
    } else {
        statut.innerHTML = ``;
        statut.insertAdjacentHTML("beforeend",
            `Le materiel n'est pas en état d'être réservé (voir "État").`);
    }
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

// FONCTIONS SERVANT A CHANGER LES INFORMATIONS

//changement des display
changeDateAdd.onclick = function() {
    if (displayDateAdd == true){
        formDateAdd.style.display = 'none';
        displayDateAdd = false;
    } else {
        formDateAdd.style.display = 'block';
        displayDateAdd = true;
    }
};
changeDesc.onclick = function() {
    if (displayDesc == true){
        formDesc.style.display = 'none';
        displayDesc = false;
    } else {
        formDesc.style.display = 'block';
        displayDesc = true;
    }
};
changeEtat.onclick = function() {
    if (displayEtat == true){
        formEtat.style.display = 'none';
        displayEtat = false;
    } else {
        formEtat.style.display = 'block';
        displayEtat = true;
    }
};
changePrblm.onclick = function() {
    if (displayPrblm == true){
        formPrblm.style.display = 'none';
        displayPrblm = false;
    } else {
        formPrblm.style.display = 'block';
        displayPrblm = true;
    }
};

//gère les données rentrées par les admins
validateDateAdd.onclick = function (){
    let dateAdd = document.getElementById('dateAdd').value;
    let elmt = 'date_add'
    updateInfo(elmt,dateAdd);
}
validateDesc.onclick = function (){
    let newDesc = document.getElementById('newDesc').value;
    let elmt = 'description';
    updateInfo(elmt, newDesc);
}
validateEtat.onclick = function (){
    let newEtat = document.getElementById('newEtat').value;
    let room = null;
    let in_repair = 0;
    let obsolete = 0;
    if (newEtat === 'stock'){
        updateEtat(room, in_repair, obsolete)
    } else if (newEtat === 'repair'){
        in_repair = 1;
        updateEtat(room, in_repair, obsolete)
    } else if (newEtat === 'obsolete'){
        obsolete = 1;
        updateEtat(room, in_repair, obsolete)
    } else {
        listRoom();
    }
}
function selectRoom(data){
    console.log('hello');
    formRoom.style.display = 'block';
    let html = ``;
    data.forEach(elt => {
        html += `<option value="${elt.id_room}">${elt.name_room}</option>`;
        console.log(html)
    })
    console.log(data);
    newRoom.insertAdjacentHTML("beforeend", html);
    console.log('non');
}

validateRoom.onclick = function () {
    let newRoom = document.getElementById('newRoom').value;
    let room = newRoom;
    let in_repair = 0;
    let obsolete = 0;
    updateEtat(room, in_repair, obsolete)

}
validatePrblm.onclick = function (){
    console.log('ok');
    let newPrblm = document.getElementById('newPrblm').value;
    console.log(newPrblm);
    addPrblm(newPrblm);
}


// FONCTIONS SERVANT A FAIRE DES REQUETES A L'API
// list
function findMaterial(){
    const url = new URL(window.location.href);
    const id_material = url.searchParams.get("id_mat");
    const payload = {
        'id_material' : id_material,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/material/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data[0];
            update_infosMateriel(data);
            findModel(data);
            findProblem(data);
            findReservation(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function findModel(data){
    const id_model = data.id_model;
    const payload = {
        'id_model' : id_model,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/model/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data[0];
            update_infosModele(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function findProblem(data){
    const id_material = data.id_material;
    const payload = {
        'id_material' : id_material,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/problem/list'
    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data;
            update_infosProblem(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function findRoom(data){
    const payload = {
        'id_room' : data.id_room,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/room/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data[0];
            update_inRoom(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function listRoom(data){
    const payload = {
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/room/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data;
            console.log(data);
            selectRoom(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function findReservation(data){
    const payload = {
        'id_material' : data.id_material,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/reservation/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data;
            findCart(data.id_res);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
function findCart(id_res){
    const url = new URL(window.location.href);
    const id_material = url.searchParams.get("id_mat");
    const payload = {
        'id_res' : id_res,
        'id_material' : id_material
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/reservation/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data;
            update_historiqueRes(data);
            update_statutMateriel(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
//update
function updateInfo(elmt , new_info) {
    const url = new URL(window.location.href);
    const id_material = url.searchParams.get("id_mat");
    const payload = {
        'id_material': id_material,
         [elmt] : new_info
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
function updateEtat(id_room, in_repair, obsolete) {
    const url = new URL(window.location.href);
    const id_material = url.searchParams.get("id_mat");
    const payload = {
        'id_material': id_material,
        'id_room' : id_room,
        'in_repair' : in_repair,
        'obsolete' : obsolete
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
// add
function addPrblm(newPrblm) {
    const url = new URL(window.location.href);
    const id_material = url.searchParams.get("id_mat");
    const payload = {
        'id_material': id_material,
        'problem_desc': newPrblm
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/problem/add'

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



