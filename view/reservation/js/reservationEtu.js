"use strict"

class ReservationEtu extends Reservation {
    constructor() {
        super();
        this.url = new URL(window.location.href);
        this.login = this.url.searchParams.get("login");
        this.urlAPI = 'https://asaed4.gremmi.fr/api/reservation/list';
        this.payload = {"login": this.login};
        this.titlePage = document.querySelector('.titlePage');
        this.containerListRes = document.querySelector(".reservationListContainer");
        this.infoEtu = [];
        this.userClass = "";
        this.getInfo();
    }

    async getInfo() {
        this.infoEtu = await super.getUserInfos(this.login);
        console.log(this.login)
        await super.getAllReservation(this.urlAPI, this.payload);
        await this.getResDate();
        this.displayInfoEtu();
        this.displayAllRes();
    }

    async getResDate() {
        for (const res of this.allRes) {
            let id_res = res.id_res;
            let l_url = "https://asaed4.gremmi.fr/api/reservation/list";
            let l_payload = {"id_res":id_res};
            res.date = await super.getResDate(l_url, l_payload);
        }
    }

    displayInfoEtu() {
        let classes = this.infoEtu.classes;
        this.userClass = super.getCorrectClassName(classes);

        let userInfoHTML = `${this.infoEtu.name} ${this.infoEtu.first_name} ${this.userClass}`;
        this.titlePage.innerHTML = userInfoHTML;
    }

    displayAllRes() {
        for (const res of this.allRes) {
            let statusId = res.id_status;
            let status = statusName[statusId];
            let resHTML = `<div class="reservation#${res.id_res}">
                            <h2>Réservation #${res.id_res}</h2>
                            <h2>Status : ${status}</h2>
                            <div class="materielList">
                            <h3>Matétiel : </h3>
                            <ul>`;
            let materiel = res.material;
            if (materiel !== null){
                for (let matId = 0; matId < materiel.length; matId++) {
                        resHTML += `<li>${materiel[matId].name_model} #${materiel[matId].number}</li>`;
                }
            }
            else {
                resHTML += "<p>pas de matériel</p>";
            }

            resHTML += `</ul>
                            </div>
                            <div class="resDate">
                            <h3>Date :</h3>`;
                if (res.date !== null) {resHTML += ` <p>Du ${res.date.date_begin} au ${res.date.date_end}</p>`}
                           resHTML += `</div>
                            </div>`;

            this.containerListRes.insertAdjacentHTML('beforeend',resHTML)
        }
    }
}

let reservationEtuHome = new ReservationEtu();
console.log(reservationEtuHome)