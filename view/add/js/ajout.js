//CREATION DES DIFFERENTS FORMULAIRE DYNAMIQUE
let material = document.getElementById("material");
let model = document.getElementById("model");
let room = document.getElementById("room");


//VARIABLES DE STOCKAGE
let modelData = {};
let typeData = {};
let materialData = {};


//LES EVENTS LISTENERS
window.addEventListener('load', findModel);
window.addEventListener('load', findType);
window.addEventListener('load', findMaterial);

function findModel(){
    var payload = {};

    APIcallPOST('https://asaed4.gremmi.fr/api/model/list', payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            modelData = JSON.parse(response);
            modelData = modelData.data;
            console.log(modelData);
            HandleModelData(modelData);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

function HandleModelData(resultModel){
    let material_form = `<form id="addmat"> <label htmlFor="mat_model">Modèle </label>
        <select id="mat_model" required>`

    resultModel.forEach(model => {
        //console.log(model);
        material_form += `<option value="${model.id_model}">${model.name_model}</option>`;
    });

    material_form += `</select> 
        <label for="dateadd">Date d'ajout </label>
        <input type="date" id="dateadd">
        <label htmlFor="description">Description technique </label> 
        <textarea id="description" rows="4" cols="50" placeholder="Ici décrire les spécificités du matériel"></textarea>
        <input type="button" value="Ajouter" id="add_material" class="button-main addinpagebutton"> 
        </form>`

    material.insertAdjacentHTML('beforeend', material_form);
    add_material = document.getElementById('add_material');
    add_material.addEventListener('click', AddMaterial);
}

function AddMaterial(){
    //RECUPERATION DU MODEL DU MATERIEL
    let model =  parseInt(document.getElementById("mat_model").selectedOptions[0].value);
    let desc = "none"
    //RECUPERATION DE LA DESCRIPTION DU MATERIEL
    console.log(document.getElementById("description").value);
    if (document.getElementById("description").value){
        desc =  document.getElementById("description").value;
        console.log(desc);
    }
    let date_add = new Date().toJSON().slice(0, 10);
    if(document.getElementById("dateadd").value){
        date_add = document.getElementById("dateadd").value;
    }


    // AJOUT D'UN MATERIEL
    payload = {
        'id_model' : model,
        'date' : date_add,
        'obsolete' : 0,
        'in_repair' : 0
    };
    if(desc !== "none"){
        payload['description'] = desc;
    }

    const urlAPI = 'https://asaed4.gremmi.fr/api/material/add'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            console.log(response);
            window.location.reload();
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}


function findType() {
    var payload = {};

    APIcallPOST('https://asaed4.gremmi.fr/api/type/list', payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            typeData = JSON.parse(response);
            typeData = typeData.data;
            console.log(typeData);
            HandleTypeData(typeData);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

function HandleTypeData(resultType){
    let model_form = `<form id="addmodel">
                <label for="modelName">Nom </label>
                <input type="text" id="modelName" placeholder="Le nom du modèle" required>

                <label for="modeltype">Type </label>
                <select id="modeltype" required>`


    resultType.forEach(type => {
        console.log(type);
        model_form += `<option value="${type.id_type}">${type.name_type}</option>`;
    });

    model_form += `</select>

                <label for="descriptionmodel">Description du modèle </label>
                <textarea id="descriptionmodel" rows="4" cols="50" required placeholder="Ici décrire le modèle"></textarea>

                <label for="img">Image </label>
                <input type="file"
                       id="img" name="img"
                       accept="image/png, image/jpeg">

                <input type="button" value="Ajouter" id="add_model" class="button-main addinpagebutton">
        </form>`

    model.insertAdjacentHTML('beforeend', model_form);
    add_model = document.getElementById('add_model');
    add_model.addEventListener('click', AddModel);
}


function AddModel(){
    //RECUPERATION DES INFOS
    let type =  parseInt(document.getElementById("modeltype").selectedOptions[0].value);
    let name = document.getElementById("modelName").value;
    let desc = document.getElementById("descriptionmodel").value;
    let img = document.getElementById("img").value;

    // AJOUT D'UN MODEL
    payload = {
        'name_model' : name,
        'id_type' : type,
        'desc_model' : desc,
    };
    if(img !== "none"){
        payload['img'] = img;
    }

    const urlAPI = 'https://asaed4.gremmi.fr/api/model/add'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            console.log(response);
            window.location.reload();
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

function findMaterial() {
    var payload = {
        'id_room' : null
    };

    APIcallPOST('https://asaed4.gremmi.fr/api/material/list', payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            materialData = JSON.parse(response);
            materialData = materialData.data;
            console.log(materialData);
            HandleMatData(materialData);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

function HandleMatData(resultMat){
    let room_form = `<form id="addroom">
                <label for="roomName">Nom </label>
                <input type="text" id="roomName" placeholder="Le nom de la salle" required>
                 <label for="room_mat">Sélectioner le matériel dans cette salle</label>
                <select id="room_mat" multiple>`

    resultMat.forEach(mat => {
        console.log(mat);
        room_form += `<option value="${mat.id_material}">${mat.name_model} ${mat.number}</option>`;
    });

    room_form += `</select>
                <input type="button" value="Ajouter" id="add_room" class="button-main addinpagebutton">
            </form>`

    room.insertAdjacentHTML('beforeend', room_form);
    add_room = document.getElementById('add_room');
    add_room.addEventListener('click', AddRoom);
}

function AddRoom(){
    //RECUPERATION DES INFOS
    let materialsinroom =  document.getElementById("room_mat").selectedOptions;
    let name = document.getElementById("roomName").value;

    // AJOUT D'UNE SALLE
    payload = {
        'name_room' : name,
    };
    const urlAPIroomadd = 'https://asaed4.gremmi.fr/api/room/add'
    APIcallPOST(urlAPIroomadd, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            console.log(response);
            GetRoomID(name, materialsinroom);
            window.location.reload();
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

function GetRoomID(roomname, materialsinroom){
    // AJOUT D'UNE SALLE
    payload = {
        'name_room' : roomname,
    };
    const urlAPIroomadd = 'https://asaed4.gremmi.fr/api/room/list'
    APIcallPOST(urlAPIroomadd, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            let data = JSON.parse(response);
            data = data.data[0].id_room;
            console.log(data);
            if (materialsinroom.length > 0){
                UpdateMaterial(materialsinroom, data);
            }
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}


function UpdateMaterial(materialsinroom, roomid){
    for ( var i = 0; i < materialsinroom.length; i++ ) {
        console.log(materialsinroom[i].value);
        payload = {
            'id_material' : materialsinroom[i].value,
            'id_room' : roomid
        };

        const urlAPI = 'https://asaed4.gremmi.fr/api/material/update'

        APIcallPOST(urlAPI, payload)
            .then((response) => {
                // Utilisez la réponse de l'API ici
                console.log(response);
            })
            .catch((error) => {
                // Gérer les erreurs ici
                console.error(error);
            });
    }
}

//INITIALISATION DES ONGLETS
let tablinks = document.querySelectorAll(".tablinks");

tablinks.forEach(link => {
 link.addEventListener('click', function (ev){
     console.log(ev.target.dataset.tab);

     let activetab = document.querySelector(".tablinks.active");
     activetab.classList.remove("active");
     let displaycontent = document.querySelector(".tabcontent:not(.hidden)");
     displaycontent.classList.add("hidden");

     let tabcontent = document.querySelector(ev.target.dataset.tab);
     tabcontent.classList.remove("hidden");

     ev.currentTarget.classList.add("active");

 });
})
