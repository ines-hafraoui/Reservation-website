console.log(donneesSession.id_role);
//DEFINITION DE L'EMPLACEMENT DES DONNEES PAR TYPE
const user_title = document.getElementById('title');
const user_infos = document.getElementById('infos');
const user_role = document.getElementById('user_role');
const user_problem = document.getElementById('problem');
const user_history = document.getElementById('history');

//DEFINITION DES VARIABLES POUR LES UPDATES ET INSERT
let update_role = '';
let add_problem = '';

// CREATION DES VARIABLES DE RECUP DES DONNEES DE L'API
let user_data = {};
let role_data = {};
let class_data = {};
let problem_data = {};
let history_data = [];
let problem_material = {};
let material_res = {};

//LES DONNEES D'URLS RECUPEREES
const url = new URL(window.location.href);
const login = url.searchParams.get("login");
const urlAPIclass = 'https://asaed4.gremmi.fr/api/user/list'

//EVENT LISTENER AU CHARGEMENT
window.addEventListener('load', findRole);


function findRole() {
    // RECUP DES ROLES
    var payload = {};

    APIcallPOST('https://asaed4.gremmi.fr/api/role/list', payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            role_data = JSON.parse(response);
            role_data = role_data.data;
            findClass(role_data);
            // console.log(role_data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}


function findClass(role_data){
    //RECUP DES CLASSES D'UN UTILISATEUR
    const urlAPIclass = 'https://asaed4.gremmi.fr/api/user/list'
    payload = {
        'login' : login,
        'allclass' : true
    };

    APIcallPOST(urlAPIclass, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            class_data = JSON.parse(response);
            class_data = class_data.data;
            findUser(class_data, role_data)
            // console.log(class_data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

function findUser(class_data, role_data){
    // RECUP DES DONNEES UTILISATEURS
    payload = {
        'login' : login,
    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/user/list'

    APIcallPOST(urlAPI, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            user_data = JSON.parse(response);
            user_data = user_data.data[0];
            // console.log(user_data);
            findUserProblem(payload);
            handleUserData(user_data, role_data, class_data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

function findUserProblem(payload){
    //RECUP DES PROBLEMES D'UN UTILISATEUR
    const urlAPIproblem = 'https://asaed4.gremmi.fr/api/problem/list'

    APIcallPOST(urlAPIproblem, payload)
        .then((response) => {
            // Utilisez la réponse de l'API ici
            problem_data = JSON.parse(response);
            problem_data = problem_data.data;
            // console.log(problem_data);
            findUserHistory();
            handleUserProblem(problem_data);
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

//RECUPERATION DES DONNEES DE L'HISTORIQUE
function findUserHistory() {
    var payload = {
        'login': login,
    };

    //RECUP DES RESERVATIONS D'UN UTILISATEUR
    const urlAPIhistory = 'https://asaed4.gremmi.fr/api/reservation/list'

    APIcallPOST(urlAPIhistory, payload)
        .then((response) => {
            history_data = JSON.parse(response);
            history_data = history_data.data;
            // console.log(history_data);
            // Utilisez la réponse de l'API ici
            var data = JSON.parse(response);
            if (data.data.length === 0) {
                console.log('User is not running reservation yet')
                idCurrentReservation = null
            } else {
                data = data.data;
                //console.log(data);
                console.log('User is already running a reservation')
                data.forEach((d) => {
                    idCurrentReservation = d.id_res
                    APIcallPOST(urlAPIhistory, {"id_res": idCurrentReservation})
                        .then((response) => {
                            var dataCart = JSON.parse(response);
                            dataCart = dataCart.data[0];
                            history_data.push(dataCart);
                            //console.log(history_data);
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                })
            }
            findUserMemberHistory();
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

function findUserMemberHistory(){
    //RECUP DES RESERVATIONS D'UN UTILISATEUR EN TANT QUE MEMBRE
    const urlAPImember = 'https://asaed4.gremmi.fr/api/reservation/list'
    payload = {
        'member' : login,
    };
    APIcallPOST(urlAPImember, payload)
        .then((response) => {
            var data = JSON.parse(response);
            if (data.data.length === 0) {
                if(history_data.length > 0){
                    history_data = CleanUpArray(history_data);
                    console.log(history_data);
                    handleUserHistory(history_data);
                }
                console.log('User is not running a reservation as a member yet')
                idCurrentReservation = null
            } else {
            // Utilisez la réponse de l'API ici
                console.log('User is running a reservation as a member')
            let data = JSON.parse(response);
            data = data.data;
            data.forEach(member => {
                if(member.login === login){
                    console.log(login);
                    history_data.push(member);
                }
            });
            history_data = CleanUpArray(history_data);
            console.log(history_data);
            handleUserHistory(history_data);}
        })
        .catch((error) => {
            // Gérer les erreurs ici
            console.error(error);
        });
}

async function findMaterialRes(id_res) {
    const urlAPImember = 'https://asaed4.gremmi.fr/api/material/list';
    const payload = {
        'id_res': id_res,
    };

    try {
        const material_res = await APIcallPOST(urlAPImember, payload);
        return material_res;
    } catch (error) {
        console.error(error);
        throw error; // Re-throw the error to be handled by the caller if needed
    }
}

    //PREPARATION DES LISTES POUR L'HISTORIQUE
    function CleanUpArray(Array){
        let resDistinct = [];
        let stockId = [];
        Array.forEach((e) => {
            if (e.date_end && stockId.indexOf(e.id_res) == -1) {
                resDistinct.push(e);
                stockId.push(e.id_res);
            }
        })
        return resDistinct;
    }



//LA PRESENTATION DES DONNEES SUR LA PAGE
function handleUserData(results_user, results_role, results_class) {
    let html = `<h1>${results_user.name} ${results_user.first_name}</h1>`;
    user_title.insertAdjacentHTML('beforeend', html);

    results_role.forEach(role => {
        if(role.id_role === results_user.id_role){
            // console.log(role.name_role);
            html = `<div><h4>Rôle : </h4>`;
            if (donneesSession.id_role == 1){
                html += `<img id="modif_role" class="modify detailuserform" src="../../img/crayon-de-couleur.png"></div>`;
            }
            html += `<p>${role.name_role}</p>`;

        }
    })
    user_role.insertAdjacentHTML('afterbegin', html);
    if (donneesSession.id_role == 1) {
        update_role = document.getElementById('modif_role');
        console.log(update_role);
        update_role.addEventListener('click', UpdateRoleForm);
    }
    console.log(results_class.length);
    if (results_class.length > 0){
        let html2 = `<div><h4>Classe : </h4>`;
        results_class.forEach(classe => {
            // console.log(classe);
            html2 += `<p> ${classe.name_class}</p></div>
                `;
        })
        user_infos.insertAdjacentHTML('beforeend', html2);
    }
}

function handleUserProblem(results_problem) {
    let html = `<div><h4> Problèmes :`;
    if (donneesSession.id_role == 1) {
        html += `</h4> <img id="add_problem" class="modify detailuserform" src="../../img/Plus-icon.png"></div>`;
    }
    html += `<ul>`;
    // console.log(results_problem);
    results_problem.forEach(problem => {
        html += `<li> ${problem.problem_desc}</li> `;
    })
    html += `</ul>`;
    user_problem.insertAdjacentHTML('afterbegin', html);
    if (donneesSession.id_role == 1) {
        add_problem = document.getElementById('add_problem');
        add_problem.addEventListener('click', AddProblemForm);
    }
}

async function handleUserHistory(results_history) {
    let html = `<h4>  Historique : </h4>`;
    console.log(results_history);
    html += `<table>
              <thead>
                <tr>
                  <th>Réservation</th>
                  <th>Matériel</th>
                  <th>Date de début</th>
                  <th>Date de fin(théorique)</th>
                  <th>Date du retour</th>
                </tr>
              </thead>
              <tbody>`;

    for (const elt of results_history) {
            try {
                const materialres = await findMaterialRes(elt.id_res);
                // console.log(materialres);
                    html += `<tr>
                      <td><a href="../reservation/detail.php?id_res=${elt.id_res}">${elt.id_res}</a></td>
                      <td>`;
                    const data = JSON.parse(materialres).data;
                    // console.log(data);
                    data.forEach((elt) => {
                        html += `<a href="../material/detail.php?id_mat=${elt.id_material}">${elt.name_model} ${elt.number}</a> <br> `;
                    });
                    html += `</td>
                    <td>${elt.date_begin}</td>
                    <td>${elt.date_end}</td>
                    <td>${elt.date_return}</td>
                  </tr>`;
            } catch (error) {
                console.error(error);
            }
    }

    html += `</tbody>
            </table>`;
    user_history.insertAdjacentHTML('beforeend', html);
}


//FORMULAIRE DE MODIFICATION/AJOUT DISPONIBLE SEULEMENT POUR LE SUPER-ADMIN

//POUR AJOUTER UN PROBLEME
function AddProblemForm(){
    removeAllChildNodes(document.getElementById("user_problemform"));
    let html = `
  <form>
    <label for="desc">Description:</label>
    <textarea id="desc" name="desc" rows="4" cols="50" required></textarea>
    `;
    console.log(history_data);
    history_data = CleanUpArray(history_data);
    if(history_data.length > 0 ){
        html += `<label for="reservation">Lier le problème à une reservation:</label>
        <select id="reservation" name="reservation">
        <option value="none">Aucune</option>`;

        history_data.forEach(res => {
            html += `<option value="${res.id_res}">${res.id_res}</option>`;
        })
        html +=`</select>`;
    }

    html +=`<input type="button" value="Valider" id="problemadd" class="button-main">
  </form>`;


    document.getElementById("user_problemform").insertAdjacentHTML('beforeend', html);
    add_problem = document.getElementById('problemadd');
    add_problem.addEventListener('click', AddProblem);
}

function AddProblem(){
    //RECUPERATION DE LA RESERVATION DEFINIT POUR LE PROBLEME
    let reservation = "none";
    let material = "none";
    console.log(document.getElementById("reservation"));
    if(document.getElementById("reservation")){
        reservation =  document.getElementById("reservation").selectedOptions[0].value;
        console.log(reservation);
    }

    //RECUPERATION DE LA DESCRIPTION DU PROBLEME
    let desc =  document.getElementById("desc").value;
    console.log(desc);

    // AJOUT D'UN PROBLEME
        payload = {
            'login' : login,
            'problem_desc' : desc,
        };
        if(reservation !== "none"){
            payload['id_res'] = reservation;
        }

        const urlAPI = 'https://asaed4.gremmi.fr/api/problem/add'

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


//MODIFIER LE ROLE
function UpdateRoleForm(){
    removeAllChildNodes(document.getElementById("user_roleform"));
    let html = `<label for="role">Changer le role de cet utilisateur :</label>
        <select id="role" name="role">`
    role_data.forEach(role => {
        if(role.id_role === user_data.id_role){
            // console.log(role.name_role);
            html += `<option value="${role.id_role}" selected>${role.name_role}</option>`;
        }
        else{
            html += `<option value="${role.id_role}">${role.name_role}</option>`;
        }
    });
    html +=`</select>
    <input type="button" value="Valider" id="role_change" class="button-main">
  </form>`;
    document.getElementById("user_roleform").insertAdjacentHTML('beforeend', html);
    update_role = document.getElementById('role_change');
    console.log(update_role);
    update_role.addEventListener('click', UpdateRole);
}

function UpdateRole(){
    let role =  document.getElementById("role").selectedOptions[0].value;
    console.log(role);

    // UPDATE DES DONNEES UTILISATEURS
    payload = {
        'login' : login,
        'id_role' : role

    };
    const urlAPI = 'https://asaed4.gremmi.fr/api/user/update'

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

