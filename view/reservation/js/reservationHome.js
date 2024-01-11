"use strict"
// pour à venir : order by date (ajouter dans l'API car n'existe pas)

// function  Reservation() {
//     this.currentDate = new Date();
//     getCurrentDateTime()
// }

class ReservationHome extends Reservation {
    constructor() {
        super();
        this.containerInComing = document.querySelector('.rerservation-a-venir');
        this.urlAPI = "https://asaed4.gremmi.fr/api/reservation/list";
        this.payload = {};
        this.getAllRes()
    }

    async getAllRes() {
        await super.getAllReservation(this.urlAPI, this.payload);
        this.displayHome(this.allRes);
    }

    async displayHome(reservations) {
        await  this.displayWaitingRes(reservations);
        await this.displayResInComing(reservations);
        await this.displayCurrentRes(reservations);
    }

    displayCurrentRes(res) {

        let waitingRes = this.filterByStatus(res, status.given);
        let reservations = this.getCurrentRes(waitingRes);

        let titleWaitingRes = document.createElement('h2');
        titleWaitingRes.innerHTML = "Réservations en cours :";
        this.containerInComing.appendChild(titleWaitingRes);
        for (const res of reservations) {
            let reservationDiv = document.createElement('div');
            reservationDiv.setAttribute('class','reservationDiv res'+res.id_res);
            let titleRes = document.createElement('h3');
            titleRes.innerHTML = res.login ;

            if (res.userInfos.classes) {
                let classes = res.userInfos.classes
                let className = this.getCorrectClassName(classes);
                titleRes.innerHTML += " (" + className+")";
            }

            let resDiv = document.createElement('div');
            resDiv.setAttribute('class','reservationInfos');

            let resId = document.createElement('h4');
            resId.setAttribute('class','reservation_id');
            resId.innerHTML = "Réservation #" + res.id_res;

            let date = document.createElement('h5');
            date.innerHTML = " du " + res.date_begin + " au " + res.date_end;
            date.setAttribute('class','reservation_date');

            resDiv.appendChild(resId)
            resDiv.appendChild(date);


            let materielDiv = document.createElement('div');
            materielDiv.setAttribute('class','materialDiv');

            let materielTitle = document.createElement('h4');
            materielTitle.innerHTML ="Matériel";

            let materielList = res.material;
            for (const mat of materielList) {
                let matTitle = document.createElement('h5');
                matTitle.innerHTML = mat.name_model + " #" + mat.number;
                materielDiv.appendChild(matTitle);
            }

            let btnDiv = document.createElement('div');
            btnDiv.setAttribute('class','buttonDiv');

            var buttonValid = document.createElement('input');
            buttonValid.setAttribute('class','button-main');
            buttonValid.type = 'button';
            buttonValid.id = 'validCurrentRes';
            buttonValid.name = 'validCurrentRes';
            buttonValid.value = 'récupérer';
            btnDiv.appendChild(buttonValid);

            super.updateResStatusEvent(buttonValid, res.id_res, status.reclaimed);

            var buttonModif = document.createElement('input');
            buttonModif.setAttribute('class','button-main');
            buttonModif.type = 'button';
            buttonModif.id = 'modifCurrentRes';
            buttonModif.name = 'modifCurrentRes';
            buttonModif.value = 'remarque';
            btnDiv.appendChild(buttonModif);

            buttonModif.addEventListener('click',() => {
                this.addProblem(btnDiv, res.id_res)
            });


            reservationDiv.appendChild(titleRes);
            reservationDiv.appendChild(materielDiv);
            reservationDiv.appendChild(resDiv);
            reservationDiv.appendChild(btnDiv);

            this.containerInComing.appendChild(reservationDiv);
        }
    }

    addProblem(container, id_res){

        let problemDesc = document.createElement('textarea');
        problemDesc.setAttribute('class','textProblem');

        let submitPb = document.createElement('input');
        submitPb.type = 'button';
        submitPb.id = 'submitProblemBtn';
        submitPb.value = 'envoyer';

        container.appendChild(problemDesc);
        container.appendChild(submitPb);


        submitPb.addEventListener('click',async () => {
            let l_url = "https://asaed4.gremmi.fr/api/problem/add";
            let problem_desc = problemDesc.value;
            let l_payload = {"id_res":id_res, "problem_desc":problem_desc}

            APIcallPOST(l_url, l_payload)
                .catch((error) => console.log(error))
        })
    }

    getCurrentRes(allRes) {
        console.log(allRes)
        let reservations = [];
        for (const res of allRes) {
            if (this.currentDate >= res.date_begin && this.currentDate <= res.date_end) {

                reservations.push(res)
            }
        }
        reservations.sort(function(a, b) {
            var dateA = new Date(a.date_begin);
            var dateB = new Date(b.date_begin);
            return dateA - dateB;
        })
        return reservations
    }

    displayWaitingRes(res) {
        let reservations = this.filterByStatus(res, status.waiting);
        //   let reservations = this.sortByDateBegin(waitingRes);  ajouter une autre fonction pour trier par date ?

        let titleWaitingRes = document.createElement('h2');
        titleWaitingRes.innerHTML = "Réservations à valider :";
        this.containerInComing.appendChild(titleWaitingRes);
        for (const res of reservations) {
            let reservationDiv = document.createElement('div');
            reservationDiv.setAttribute('class','reservationDiv res'+res.id_res);
            let titleRes = document.createElement('h3');
            titleRes.innerHTML = res.login ;

            if (res.userInfos.classes) {
                let classes = res.userInfos.classes
                let className = this.getCorrectClassName(classes);
                titleRes.innerHTML += " (" + className+")";
            }

            let resDiv = document.createElement('div');
            resDiv.setAttribute('class','reservationInfos');

            let resId = document.createElement('h4');
            resId.setAttribute('class','reservation_id');
            resId.innerHTML = "Réservation #" + res.id_res;

            let date = document.createElement('h5');
            date.innerHTML = " du " + res.date_begin + " au " + res.date_end;
            date.setAttribute('class','reservation_date');

            resDiv.appendChild(resId)
            resDiv.appendChild(date);


            let materielDiv = document.createElement('div');
            materielDiv.setAttribute('class','materialDiv');

            let materielTitle = document.createElement('h4');
            materielTitle.innerHTML ="Matériel";

            let materielList = res.material;
            for (const mat of materielList) {
                let matTitle = document.createElement('h5');
                matTitle.innerHTML = mat.name_model + " #" + mat.number;
                materielDiv.appendChild(matTitle);
            }

            let btnDiv = document.createElement('div');
            btnDiv.setAttribute('class','buttonDiv');

            var buttonValid = document.createElement('input');
            buttonValid.setAttribute('class','button-main');
            buttonValid.type = 'button';
            buttonValid.id = 'validWaitingRes';
            buttonValid.name = 'validWaitingRes';
            buttonValid.value = 'valider';
            btnDiv.appendChild(buttonValid);

            super.updateResStatusEvent(buttonValid, res.id_res, status.accepted);


            var buttonReject = document.createElement('input');
            buttonReject.setAttribute('class','button-main');
            buttonReject.type = 'button';
            buttonReject.id = 'rejectWaitingRes';
            buttonReject.name = 'rejectWaitingRes';
            buttonReject.value = 'rejeter';
            btnDiv.appendChild(buttonReject)

            super.updateResStatusEvent(buttonReject, res.id_res, status.refused);

            reservationDiv.appendChild(titleRes);
            reservationDiv.appendChild(materielDiv);
            reservationDiv.appendChild(resDiv);
            reservationDiv.appendChild(btnDiv);

            this.containerInComing.appendChild(reservationDiv);
        }
    }

    async displayResInComing(allReservations) {
        let inComingRes = this.filterByStatus(allReservations, status.accepted);
        let reservations = this.sortByDateBegin(inComingRes);

        let titleResInComing = document.createElement('h2');
        titleResInComing.innerHTML = "Réservations à venir :";
        this.containerInComing.appendChild(titleResInComing);

        for (const res of reservations) {
            let reservationDiv = document.createElement('div');
            reservationDiv.setAttribute('class','reservationDiv res'+ res.id_res);
            let titleRes = document.createElement('h3');
            titleRes.innerHTML = res.login ;

            if (res.userInfos.classes) {
                let classes = res.userInfos.classes
                let className = this.getCorrectClassName(classes);
                titleRes.innerHTML += " (" + className+")";
            }

            let resDiv = document.createElement('div');
            resDiv.setAttribute('class','reservationInfos');

            let resId = document.createElement('h4');
            resId.setAttribute('class','reservation_id');
            resId.innerHTML = "Réservation #" + res.id_res;

            let date = document.createElement('h5');
            date.innerHTML = " du " + res.date_begin + " au " + res.date_end;
            date.setAttribute('class','reservation_date');

            resDiv.appendChild(resId)
            resDiv.appendChild(date);


            let materielDiv = document.createElement('div');
            materielDiv.setAttribute('class','materialDiv');

            let materielTitle = document.createElement('h4');
            materielTitle.innerHTML ="Matériel";

            let materielList = res.material;
            for (const mat of materielList) {
                let matTitle = document.createElement('h5');
                matTitle.innerHTML = mat.name_model + " #" + mat.number;
                materielDiv.appendChild(matTitle);
            }

            let btnDiv = document.createElement('div');
            btnDiv.setAttribute('class','buttonDiv');

            var buttonValid = document.createElement('input');
            buttonValid.setAttribute('class','button-main');
            buttonValid.type = 'button';
            buttonValid.id = 'validInComingRes';
            buttonValid.name = 'validInComingRes';
            buttonValid.value = 'confier';
            btnDiv.appendChild(buttonValid);

            super.updateResStatusEvent(buttonValid, res.id_res, status.given);

            var buttonReject = document.createElement('input');
            buttonReject.setAttribute('class','button-main');
            buttonReject.type = 'button';
            buttonReject.id = 'deleteInComingRes';
            buttonReject.name = 'deleteInComingRes';
            buttonReject.value = 'refuser';
            btnDiv.appendChild(buttonReject);

            super.updateResStatusEvent(buttonReject, res.id_res, status.refused);

            reservationDiv.appendChild(titleRes);
            reservationDiv.appendChild(materielDiv);
            reservationDiv.appendChild(resDiv);
            reservationDiv.appendChild(btnDiv)

            this.containerInComing.appendChild(reservationDiv);
        }
    }

    filterByStatus(allRes, status) {
        let reservations = []
        for (const res of allRes) {
            if (res.id_status === status) {
                reservations.push(res);
            }
        }
        return reservations
    }


    sortByDateBegin(allReservations) {
        var reservations = allReservations.filter((res) => {
            var resDate = res.date_begin;
            return resDate > this.currentDate;
        });
        reservations.sort(function(a, b) {
            var dateA = new Date(a.date_begin);
            var dateB = new Date(b.date_begin);
            return dateA - dateB;
        });

        return reservations;
    }

}


    let reservationHome = new ReservationHome()
    console.log(reservationHome)









