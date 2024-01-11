"use strict";

/* Déclaration des variables */
const urlAPIReservation = 'https://asaed4.gremmi.fr/api/reservation/list'
const urlAPICreateReservation = 'https://asaed4.gremmi.fr/api/reservation/add'
const urlAPIDeleteReservation = 'https://asaed4.gremmi.fr/api/reservation/delete'
const urlAPIUpdateReservation = 'https://asaed4.gremmi.fr/api/reservation/update'
const urlAPIMaterial = 'https://asaed4.gremmi.fr/api/material/list'
const urlAPIModel = 'https://asaed4.gremmi.fr/api/model/list'
const urlAPIUser = 'https://asaed4.gremmi.fr/api/user/list'
const urlAPICreateCart = 'https://asaed4.gremmi.fr/api/cart/add'
const urlAPIAddMember = 'https://asaed4.gremmi.fr/api/member/add'
const urlAPIClass = 'https://asaed4.gremmi.fr/api/class/list'

var idCurrentReservation = null
let loginUser = donneesSession.login
let roleUser = donneesSession.id_role
var dates = []
var group = ''
let container = document.querySelector('.input-res-container')
let materialListContainer = document.querySelector('.material-list-container')
let datepickerInput = document.getElementById('datepicker')
let datepickerValidate = document.getElementById('datepicker-validate')
let validateResButton = document.getElementById('validate-reservation')
let classButton = document.querySelector('.user-res-class')

datepickerValidate.style.visibility = 'hidden'
validateResButton.style.display = 'none'

window.addEventListener('load', checkIfUserInitiatedReservation)
datepickerInput.addEventListener('change', getResByMaterialInfos)
validateResButton.addEventListener('click', checkUserStatus)

/* When a user arrives in the page, this function checks if he has initiated a reservation or not */
function checkIfUserInitiatedReservation()
{
    /*checkIfUserIsInClass()*/
    let payload = {
        "login" : loginUser,
        "id_status" : 1
    }

    APIcallPOST(urlAPIReservation, payload)
        .then((response) => {
            var data = JSON.parse(response);
            if (data.data.length === 0) {
                console.log('User is not running reservation yet')
                idCurrentReservation = null
                printDatesInput()
                console.log('coucou')
            } else {
                data = data.data[0];
                console.log('User is already running a reservation')
                idCurrentReservation = data.id_res
                validateResButton.style.display = 'block'

                APIcallPOST(urlAPIReservation, {"id_res": idCurrentReservation})
                    .then((response) => {
                        var dataCart = JSON.parse(response);
                        dataCart = dataCart.data[0];
                        dates.push(dataCart.date_begin, dataCart.date_end)

                        let payload = {
                            "date_begin" : dates[0],
                            "date_end" : dates[1]
                        }

                        getMaterials(payload)
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        })
        .catch((error) => {
            console.error(error);
        });
}


/*function checkIfUserIsInClass()
{
    let payload = {
        "res_tp":true,
    }
    APIcallPOST(urlAPIReservation, payload)
        .then((response) => {
            var datas = JSON.parse(response);
            datas = datas.data;
            console.log(datas)
            const currentDate = getCurrentDate()
            for (let data of datas) {
                console.log(currentDate)
                if (data.date_begin < currentDate && data.date_end > currentDate) {

                    APIcallPOST(urlAPIUser, {"login": loginUser, "allclass":true})
                        .then((response) => {
                            var dataClass = JSON.parse(response);
                            dataClass = dataClass.data;
                            console.log(dataClass)
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                }
            }
        })
        .catch((error) => {
            console.error(error);
        });
}*/


/* If the user has not already initiated a reservation, this function prints dates Input */
function printDatesInput()
{
    if (roleUser === 3) {
        container.insertAdjacentHTML('beforeend', `
        <div class="date-res-container">
            <h2>Choisissez vos dates d'emprunts</h2>
            <div>
                <label for="dateDay">Jour : </label>
                <input type="date" id="dateDay" name="date" required><br>
                <label for="class-hour-res">Horaire</label>
                <select id="class-hour-res">
                    <option value="08:00:00-10:00:00">08h00 - 10h00</option>
                    <option value="10:15:00-12:15:00">10h15 - 12h15</option>
                    <option value="13:45:00-15:45:00">13h45 - 15h45</option>
                    <option value="16:00:00-18:00:00">16h00 - 18h00</option>
                </select>
                <label for="class-hour-res">Groupe</label>
                <select class="class-res-value" id="class-res-value">
                    <option selected>Sélectionnez un groupe</option>
                    <option>S1A1</option>
                    <option>S1A2</option>
                    <option>S1B1</option>
                    <option>S1B2</option>
                    <option>S1C1</option>
                    <option>S1C2</option>
                    <option>S1D1</option>
                    <option>S1D2</option>
                    <option>S2A1</option>
                    <option>S2A2</option>
                    <option>S2B1</option>
                    <option>S2B2</option>
                    <option>S2C1</option>
                    <option>S2C2</option>
                    <option>S2D1</option>
                    <option>S2D2</option>
                    <option>S3A1</option>
                    <option>S3A2</option>
                    <option>S3B1</option>
                    <option>S3B2</option>
                    <option>S3C1</option>
                    <option>S3C2</option>
                    <option>S3D1</option>
                    <option>S3D2</option>
                    <option>S4A1</option>
                    <option>S4A2</option>
                    <option>S4B1</option>
                    <option>S4B2</option>
                    <option>S4C1</option>
                    <option>S4C2</option>
                    <option>S4D1</option>
                    <option>S4D2</option>
                    <option>S5A1</option>
                    <option>S5A2</option>
                    <option>S5B1</option>
                    <option>S5B2</option>
                    <option>S5C1</option>
                    <option>S5C2</option>
                    <option>S5D1</option>
                    <option>S5D2</option>
                    <option>S6A1</option>
                    <option>S6A2</option>
                    <option>S6B1</option>
                    <option>S6B2</option>
                    <option>S6C1</option>
                    <option>S6C2</option>
                    <option>S6D1</option>
                    <option>S6D2</option>
                </select>
                <button onclick="checkDatesValidity()" class="button-main">Envoyer</button>
            </div>
        </div>
        <div class="black-background"></div>
    `)
    } else {
        container.insertAdjacentHTML('beforeend', `
        
        <div class="date-res-container">
            <h2>Choisissez vos dates d'emprunts</h2>
            <button onclick="getMaterials({})" class="button-main">Fermer</button>
            <div>
                <label for="dateBegin">Date de départ : </label>
                <input type="date" id="dateBegin" name="dateBegin" required><br>
                
                <label for="dateEnd">Date de retour : </label>
                <input type="date" id="dateEnd" name="dateEnd" required><br>
        
                <button onclick="checkDatesValidity()" class="button-main">Envoyer</button>
            </div>
        </div>
        <div class="black-background"></div>
    `)
    }
}

/* Erase all html elements linked to the prints dates Input */
function closeDatesInput()
{
    let boxDatesInput = document.querySelector('.date-res-container')
    let background = document.querySelector('.black-background')
    if (boxDatesInput) {
        boxDatesInput.parentNode.removeChild(boxDatesInput);
        background.parentNode.removeChild(background)
    }
}

/* Check if dates are filled and correct in print dates Input */
function checkDatesValidity()
{
    const currentDate = getCurrentDate()

    if (roleUser === 3) {
        let day = document.getElementById('dateDay').value
        if (day < currentDate) {
            return;
        }

        let times = document.querySelector('#class-hour-res').value
        times = times.split('-')

        dates.push(day + ' ' + times[0], day + ' ' + times[1])

        let tempGroup = document.querySelector('.class-res-value').value
        if (tempGroup === 'Sélectionnez un goupe') {
            return
        } else {
            APIcallPOST(urlAPIClass, {"name_class":tempGroup})
                .then((response) => {
                    var datas = JSON.parse(response);
                    datas = datas.data[0];
                    group = datas.id_class
                })
                .catch((error) => {
                    console.error(error);
                    return
                });
        }

    } else {

        let dateBegin = document.getElementById('dateBegin').value
        let dateEnd = document.getElementById('dateEnd').value

        if (dateBegin === '' || dateEnd === '') {
            console.log('dates non valides')
            return
        }
        if (dateEnd < dateBegin) {
            console.log('dates non valides')
            return
        }
        if (dateBegin <= currentDate) {
            console.log('dates non valides')
            return
        }
        if (subtractDates(dateEnd, dateBegin) > 3) {
            console.log('dates non valides')
            return
        }
        dates.push(dateBegin + ' 15:45:00', dateEnd + ' 10:00:00')
    }
    let payload = {
        "date_begin" : dates[0],
        "date_end" : dates[1]
    }
    getMaterials(payload)
}

function getMaterials(payload)
{
    APIcallPOST(urlAPIMaterial, payload)
        .then((response) => {
            var datas = JSON.parse(response);
            datas = datas.data;
            let dataWithoutMaterialBroken = []
            for (let data of datas) {
                if (data.obsolete !== 1 && data.in_repair !== 1 && data.id_room === null) {
                    dataWithoutMaterialBroken.push(data)
                }
            }
            closeDatesInput()
            printMaterialList(dataWithoutMaterialBroken)
        })
        .catch((error) => {
            console.error(error);
        });
}

function printMaterialList(datas)
{
    materialListContainer.innerHTML = ''
    for (let data of datas) {
        let model = data.id_model
        let payload = {"id_model" : model}
        APIcallPOST(urlAPIModel, payload)
            .then((response) => {
                var dataModel = JSON.parse(response);
                dataModel = dataModel.data[0]
                materialListContainer.insertAdjacentHTML('beforeend', `
                 <div class="material-card" style="border: 1px solid black">
                        <img src="">
                        <div>
                            <h3>${dataModel.name_model} <a href="./detail.php?id_mat=${data.id_material}">n° ${data.number}</a></h3>
                            <h4>${data.description_material}</h4>
                            <p>${dataModel.description}</p>
                        </div>
                        <div>
                            <button onclick="MaterialGlobalChecker(${data.id_material})" class="button-main"> Emprunter </button>
                        </div>
                    </div>
                `)

            })
            .catch((error) => {
                console.error(error);
            });
    }
}

function MaterialGlobalChecker(material)
{
    /* User is already running a reservation (in wishlist) */
    if (typeof idCurrentReservation == 'number') {
        let payload = {
            "id_res":idCurrentReservation,
            "id_material":material,
            "date_begin":dates[0],
            "date_end":dates[1]
        }
        addMaterialToCart(payload)
    } else {
        /* User has already fulfilled the dates input at the entrance of the page */
        if (dates.length === 2) {
            createRes(material)
        } /* User has not yet fulfilled dates input */
        else {
            datepickerInput.value = ""
            getBookedDates(material)
        }
    }
}

function addMaterialToCart(payload)
{
    APIcallPOST(urlAPICreateCart, payload)
        .then((response) => {
            printSuccessMessage('material', payload.id_material)
            validateResButton.style.display = 'block'
            getMaterials({
                "date_begin":dates[0],
                "date_end":dates[1]
            })
        })
        .catch((error) => {
            console.error(error);
        });
}

function createRes(material)
{
    let payload = {
        "login":loginUser
    }
    if (roleUser === 3) { payload.id_class = group}

    APIcallPOST(urlAPICreateReservation, payload)
        .then((response) => {
            APIcallPOST(urlAPIReservation, {"login":loginUser, "id_status":1})
                .then((response) => {
                    var data = JSON.parse(response)
                    data = data.data[0]
                    idCurrentReservation = data.id_res
                    MaterialGlobalChecker(material)
                })
                .catch((error) => {
                    console.error(error);
                });
        })
        .catch((error) => {
            console.error(error);
        });
}

function getResByMaterialInfos()
{
    console.log('coucou2')
}

function deleteReservation()
{
    let payload = {
        "login":loginUser,
        "id_status":1
    }

    APIcallPOST(urlAPIReservation, payload)
        .then((response) => {
            var datas = JSON.parse(response);
            datas = datas.data;
            if (datas.length === 0 ) {
                dates = []
                materialListContainer.innerHTML = ''
                checkIfUserInitiatedReservation()
            } else {
                var reservation = datas[0].id_res
                APIcallPOST(urlAPIDeleteReservation, {"id_res":reservation})
                    .then((response) => {
                        dates = []
                        group = ''
                        materialListContainer.innerHTML = ''
                        validateResButton.style.display = 'none'
                        checkIfUserInitiatedReservation()
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        })
        .catch((error) => {
            console.error(error);
        });
}

/* ---- Ajout des membres / classe ---- */
function checkUserStatus()
{
    if (roleUser === 3) {
        validateRes()
    } else {
        printMembersInput()
    }
}

function printMembersInput()
{
    let payload = {}
    let userList = []
    APIcallPOST(urlAPIUser, payload)
        .then((response) => {
            var data = JSON.parse(response);
            let users = data.data
            container.insertAdjacentHTML('beforeend', `
                <div class="class-res-container">
                    <h2>Précisez les membres de la réservation (sans vous inclure)</h2>
                    <div>
                        <select class="members-res-select">
                        </select>
                    </div>
                    <p class="members-res-error-message"></p>
                    <input id="members-res-value">
                    <button onclick="checkMembersValidity()" class="button-main">Valider ma reservation</button>
                </div>
            `)
            let selectUser = document.querySelector('.members-res-select')
            let membersValue = document.querySelector('#members-res-value')
            for (let user of users) {
                var optionUser = document.createElement("option");
                optionUser.textContent = user.name + ' ' + user.first_name;
                optionUser.value = user.login
                selectUser.appendChild(optionUser);
            }
            selectUser.addEventListener('change', (e) => {
                if (membersValue.value === '') {
                    membersValue.value += selectUser.value
                } else {
                    membersValue.value += ' / ' + selectUser.value
                }
            })
        })
        .catch((error) => {
            console.error(error);
        });
}

function checkMembersValidity()
{
    let membersValue = document.querySelector('#members-res-value')
    let membersError = document.querySelector('.members-res-error-message')
    let members = membersValue.value.split(" / ")
    let payload = {
        "login":loginUser,
        "id_status":1
    }

    APIcallPOST(urlAPIReservation, payload)
        .then((response) => {
            var dataRes = JSON.parse(response);
            dataRes = dataRes.data[0]
            for (let member of members) {
                APIcallPOST(urlAPIUser, {"login":member})
                    .then((response) => {
                        var data = JSON.parse(response);
                        data = data.data
                        console.log(data)
                        if (data.length === 0) {
                            membersValue.value = ''
                            membersError.textContent = 'Veuillez insérer des logins valides'
                            return
                        }
                        let payload = {
                            "id_res":dataRes.id_res,
                            "login":member
                        }
                        console.log(payload)
                        APIcallPOST(urlAPIAddMember, payload)
                            .then((response) => {
                            })
                            .catch((error) => {
                                console.log(error)
                            })
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
            validateRes()
        })
        .catch((error) => {
            console.error(error);
        });
}


function validateRes()
{
    let payload = {
        "login":loginUser,
        "id_status":1
    }
    APIcallPOST(urlAPIReservation, payload)
        .then((response) => {
            var data = JSON.parse(response);
            data = data.data[0]
            APIcallPOST(urlAPIAddMember, {"id_res":data.id_res, "login":loginUser})
                .then((response) => {
                    let payload = {
                        "id_res":data.id_res,
                        "id_status":2
                    }
                    APIcallPOST(urlAPIUpdateReservation, payload)
                        .then((response) => {
                            window.location.href = '../reservation/homeAdmin.php'
                        })
                        .catch((error) => {
                            console.error(error);
                        })
                })
                .catch((error) => {
                    console.log(error)
                })
        })
        .catch((error) => {
            console.error(error);
        });
}


/* ----- Utilities ----- */

function getCurrentDate() {
    let currentDate = new Date();
    let year = currentDate.getFullYear();
    let month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
    let day = ("0" + currentDate.getDate()).slice(-2);
    let formattedDate = year + "-" + month + "-" + day;
    return formattedDate;
}

function subtractDates(date1, date2) {
    var oneDay = 24 * 60 * 60 * 1000; // Nombre de millisecondes dans une journée
    var firstDate = new Date(date1);
    var secondDate = new Date(date2);
    var diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
    return diffDays;
}