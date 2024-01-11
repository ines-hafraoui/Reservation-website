"use strict";
// LANCER GENERATION DE LA PAGE
findModel();

//TOGGLE VARIABLE
let displayDesc = false;
let displayName = false;

// DEFINITION DES ELEMENTS HTML EN VARIABLE (pour pouvoir les modifier)
let nameModele = document.getElementById('nameModele')
let changeName = document.getElementById('changeName')
let formName = document.getElementById('formName')
let validateName = document.getElementById('validateName')
let desc = document.getElementById('desc')
let changeDesc = document.getElementById('changeDesc')
let formDesc = document.getElementById('formDesc')
let validateDesc = document.getElementById('validateDesc')
let stock = document.getElementById('stock')

// FONCTIONS SERVANT A REMPLIR LE HTML AVEC LES BONNES INFORMATIONS
function update_infosModele(dataModel){
    console.log(dataModel);
    nameModele.innerHTML = ``;
    nameModele.insertAdjacentHTML("beforeend",
        `${dataModel.name_model}`)
    desc.innerHTML = ``;
    desc.insertAdjacentHTML("beforeend",
        `${dataModel.description}`)
    // image.innerHTML = ``;
    // image.insertAdjacentHTML("beforeend",
    //     `<img src="">`)
}

async function update_stock(data){
    console.log(data);
    data.forEach(async  elt => {
        let etat = await etatMateriel(elt);
        console.log(etat);
        stock.insertAdjacentHTML("afterbegin",
            `<tr>
                <td><a href="../material/detail.php?id_mat=${elt.id_material}">${elt.id_material}</a></td>
                <td>${elt.number}</td>
                <td>${elt.description_material}</td>
                <td>${etat}</td>
                <td>${elt.date_add}</td>
            </tr>`
        )
    })
}
async function etatMateriel(data){
    if(data.obsolete === 1){
        return `obsolète`;
    } else if (data.in_repair === 1){
        return 'en réparation';
    } else if (data.id_room !== null){
        let room = await findRoom(data.id_room);
        return room;
    } else {
        return 'ok';
    }
}
async function returnRoom(data){
    console.log(data.name_room);
    return `<a href="../room/detail.php?id_room=${data.id_room}">${data.name_room}</a>`;
}

// FONCTIONS SERVANT A CHANGER LES INFORMATIONS
//changement des display
changeDesc.onclick = function() {
    if (displayDesc == true){
        formDesc.style.display = 'none';
        displayDesc = false;
    } else {
        formDesc.style.display = 'block';
        displayDesc = true;
    }
};
changeName.onclick = function() {
    if (displayName == true){
        formName.style.display = 'none';
        displayName = false;
    } else {
        formName.style.display = 'block';
        displayName = true;
    }
};
//gère les données rentrées par les admins
validateDesc.onclick = function (){
    let newDesc = document.getElementById('newDesc').value;
    let elmt = 'desc_model';
    updateInfo(elmt, newDesc);
}
validateName.onclick = function (){
    let newDesc = document.getElementById('newName').value;
    let elmt = 'name_model';
    updateInfo(elmt, newDesc);
}
// FONCTIONS SERVANT A FAIRE DES REQUETES A L'API
// list
function findModel(data){
    const url = new URL(window.location.href);
    const id_model = url.searchParams.get("id_model");
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
            findMat(id_model);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}
async function findMat(id_model){
    const payload = {
        'id_model' : id_model,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/material/list'

    let reponse = await APIcallPOST(urlAPI, payload)
        // .then((response) => {
        //     // Utilisez la réponse de l'API ici
        //     var data = JSON.parse(response);
        //     data = data.data;
        //     update_stock(data);
        // })
        // .catch((error) => {
        //     // Gérer les erreurs ici
        //     console.error(error);
        // });

    var data = JSON.parse(reponse);
    data = data.data;
    await update_stock(data);

}
//update
function updateInfo(elmt , new_info) {
    const url = new URL(window.location.href);
    const id_model = url.searchParams.get("id_model");
    console.log(elmt);
    console.log(new_info);
    const payload = {
        'id_model': id_model,
        [elmt] : new_info
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/model/update'

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
async function findRoom(id_room){
    const payload = {
        'id_room' : id_room,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/room/list'

    let room;

    await APIcallPOST(urlAPI, payload)
        .then(async (response) => {
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            data = data.data[0];
            console.log('data findRoom:', data)
            room = returnRoom(data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
    return room;
}
