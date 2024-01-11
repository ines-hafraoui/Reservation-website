"use strict"

class ReservationList extends Reservation {
    constructor() {
        super();
        this.container = document.querySelector('.divTableauHistoriqueRes');
        this.buttonSortDate = document.getElementById('sortResByDate');
        this.urlAPI = "https://asaed4.gremmi.fr/api/reservation/list";
        this.payload = {};
        this.getAllRes()
    }

    async getAllRes() {
        await super.getAllReservation(this.urlAPI, this.payload);
        this.displayHistory(this.allRes);
        this.addEventSort();
    }

    displayHistory(){
        let table = document.createElement('table');
        table.setAttribute('class','tableHistory');
        this.container.appendChild(table);

        let allRes = this.allRes;

        let thead = document.createElement('thead');
        table.appendChild(thead);
        let firstRow = document.createElement('tr');
        thead.appendChild(firstRow);

        let idTitle = document.createElement('th')
        idTitle.innerHTML = "id";
        let nameTitle = document.createElement('th');
        nameTitle.innerHTML = "Nom";
        let firstNameTitle = document.createElement('th');
        firstNameTitle.innerHTML = "Prénom";
        let materielTitle = document.createElement('th');
        materielTitle.innerHTML = "Matériel";
        let roomTitle = document.createElement('th');
        roomTitle.innerHTML = "Salle";
        let dateTitle = document.createElement('th');
        dateTitle.innerHTML = "Date";
        let statusTitle = document.createElement('th');
        statusTitle.innerHTML = "Status";
        let detailTitle = document.createElement('th');
        detailTitle.innerHTML = "Détail";
        firstRow.appendChild(idTitle);
        firstRow.appendChild(firstNameTitle);
        firstRow.appendChild(nameTitle);

        firstRow.appendChild(materielTitle);
        firstRow.appendChild(roomTitle);
        firstRow.appendChild(dateTitle);
        firstRow.appendChild(statusTitle);
        firstRow.appendChild(detailTitle);

        let tbody = document.createElement('tbody');
        table.appendChild(tbody);


        for (const res of allRes) {

            let row = document.createElement('tr');

            let id = document.createElement('td');
            id.innerHTML = "#"+res.id_res;
            let name = document.createElement('td');
            name.innerHTML = `<a href="/view/user/detail.php?login=${res.login}">${res.userInfos.name}</a>`;

            let firstName = document.createElement('td');
            firstName.innerHTML = res.userInfos.first_name;

            let materiel = res.material;
            let materielRow = document.createElement('td');
            if (materiel !== null){
                console.log(materiel)
                for (let matId = 0; matId < materiel.length; matId++) {
                    if (matId === materiel.length - 1) {
                        materielRow.innerHTML += `<a href="/view/material/detail.php?id_mat=${materiel[matId].id_material}">${materiel[matId].name_model}#${materiel[matId].number}</a>`;
                    } else {
                        materielRow.innerHTML += `<a href="/view/material/detail.php?id_mat=${materiel[matId].id_material}">${materiel[matId].name_model}#${materiel[matId].number}</a>` + ', ';
                    }
                }
            }
            else {
                materielRow.innerHTML += "pas de matériel"
            }

            let rooms = res.room;
            let roomRow = document.createElement('td');
            if (rooms !== null) {
                for (let roomId = 0; roomId < rooms.length; roomId++) {
                    if (roomId === rooms.length - 1) {
                        roomRow.innerHTML += rooms[roomId].name_room ;
                    } else {
                        roomRow.innerHTML += rooms[roomId].name_room + ', ';
                    }
                }
            }
            else {
                roomRow.innerHTML += "pas de salle";
            }

            let date = document.createElement('td');
            date.innerHTML = res.date_begin + " - " + res.date_end;
            let statusId = res.id_status;
            let status = statusName[statusId];
            let statusRow = document.createElement('td');
            statusRow.innerHTML = status;
            let detail = document.createElement('td');

            detail.innerHTML = `<a href=\"detail.php?id_res=${res.id_res}\"><h3>Détail</h3></a>`;
            row.appendChild(id);
            row.appendChild(name);
            row.appendChild(firstName);
            row.appendChild(materielRow);
            row.appendChild(roomRow);
            row.appendChild(date);
            row.appendChild(statusRow);
            row.appendChild(detail);

            tbody.appendChild(row)


        }
    }

    addEventSort() {
        this.buttonSortDate.addEventListener('click',() => {
            removeAllChildNodes(this.container);
            this.sortByDate();
            this.displayHistory();
        })
    }

    sortByDate() {
        this.allRes.sort(function(a, b) {
            var dateA = new Date(a.date_begin);
            var dateB = new Date(b.date_begin);
            return dateA - dateB;
        })
    }
}

let reservationList = new ReservationList();
console.log(reservationList)