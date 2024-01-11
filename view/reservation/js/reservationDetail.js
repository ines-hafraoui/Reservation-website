"use strict"

class ReservationDetail extends Reservation {
    constructor() {
        super();
        this.url = new URL(window.location.href);
        this.idRes = this.url.searchParams.get("id_res");
        this.infoRes = [];
        this.resMaterials = [];
        this.urlAPI = 'https://asaed4.gremmi.fr/api/reservation/list';
        this.payload = {"id_res": this.idRes};
        this.titlePage = document.querySelector('.titlePage');
        this.titlePage.innerHTML = "Réservation #" + this.idRes;
        this.containerInfoRes = document.querySelector(".infoRes");
        this.containerMaterial = document.querySelector('.materielListContainer');
        this.resRoom = [];
        this.getAllResFromUser()
    }

    async getAllResFromUser() {
        await super.getAllReservation(this.urlAPI, this.payload);
        await this.getResProblem();
        this.resRoom = await super.getResRoom();
        this.infoRes = this.allRes[0];
        this.resMaterials = await super.getMaterials(this.idRes);
        this.displayInfoRes();
        this.displayMaterial();
        this.displayRoom();
    }

    displayInfoRes() {
        console.log(this.infoRes)
        let name = this.infoRes.userInfos.name;
        let firstName = this.infoRes.userInfos.first_name;
        let roleId = this.infoRes.userInfos.id_role;
        let role = roleName[roleId];

        let allClass = this.infoRes.userInfos.classes;
        let currentClasse = super.getCorrectClassName(allClass);

        let dateBegin = this.infoRes.date_begin;
        let dateEnd = this.infoRes.date_end;
        let dateAdd = this.infoRes.date_add;
        let dateReturn = this.infoRes.date_return;

        let problems = this.infoRes.problems;

        let contentinfoRes = '';

        if (currentClasse !== null) {
            contentinfoRes = `<h3>Reponsable : ${name} ${firstName} (${currentClasse})</h3><h4>${role}</h4>`;
        }
        else {
            contentinfoRes = `<h3>Reponsable : ${name} ${firstName}</h3><h4>${role}</h4>`;
        }
        let statusId = this.infoRes.id_status;
        let status = statusName[statusId];
        contentinfoRes += `<h3>Status : ${status}</h3>`

        contentinfoRes += `
            <div class="divInfoDate"><h3>Date :</h3>
                <h4>Date début : ${dateBegin}</h4>
                <h4>Date fin : ${dateEnd}</h4>
                <h4>Date d'ajout : ${dateAdd}</h4>
                <h4>Date de retour : ${dateReturn}</h4>
            </div>
            <div class="divProblems">
                <h3>Problème(s) :</h3>
                <ul>`

        if (problems !== null) {
            for (const pb of problems) {
                contentinfoRes += `<li>(problème #${pb.id_problem}) ${pb.problem_desc}</li>`
            }
        }

        contentinfoRes += `</ul>
                            </div>`

        this.containerInfoRes.insertAdjacentHTML('beforeend', contentinfoRes);
    }

    displayMaterial() {
        let html = `<div class="materielList"> <h3>Matériel :</h3>
                `;
        if (this.resMaterials !== null) {
            for (const mat of this.resMaterials) {
                html += `<div class="${mat.name_model}#${mat.number}"><h4>${mat.name_model}#${mat.number}</h4>
                    <p>${mat.description_material} ${mat.description}</p>
                    </div>`
            }
        }
                
            html += `
                    </div>`;

        this.containerMaterial.insertAdjacentHTML('beforeend',html)
    }

    displayRoom() {
        let html = `<div class="divRoom"> <h3>Salle : </h3><ul>`;
        if (this.resRoom !== null) {
            for (const room of this.resRoom) {
                html += `<li>${room.name_room}</li>`
            }
        }
        html += `</ul></div>`;
        this.containerMaterial.insertAdjacentHTML('beforeend',html)
    }

    async getResProblem() {

        for (const res of this.allRes) {
            let l_url = "https://asaed4.gremmi.fr/api/problem/list";
            let l_payload = {"id_res": res.id_res};

            try {
                let response = await APIcallPOST(l_url, l_payload);
                let data = JSON.parse(response).data;

                res.problems = data;
            } catch (error) {
                console.error(error);
                throw error;
            }
        }
    }


}

let reservationDetail = new ReservationDetail();
console.log(reservationDetail)