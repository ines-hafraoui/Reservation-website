"use strict"

let status = {
    wishlist : 1,
    waiting : 2,
    accepted : 3,
    given : 4,
    reclaimed : 5,
    refused : 6
}

let statusName = {
    1 : "wishlist",
    2 : "En attente d'acceptation",
    3 : "accepté",
    4 : "donné",
    5 : "terminer",
    6 : "refusé"
}

let roleName = {
    1 : "super-admin",
    2 : "admin",
    3 : "enseigant",
    4 : "élève"
}

class Reservation {
    constructor() {
        this.currentDate = this.formatDate(new Date());
        this.allRes = {};
    }

    //function to get date to the SQL format :
    formatDate(date) {
        var year = date.getFullYear();
        var month = this.padZero(date.getMonth() + 1);
        var day = this.padZero(date.getDate());
        var hours = this.padZero(date.getHours());
        var minutes = this.padZero(date.getMinutes());
        var seconds = this.padZero(date.getSeconds());

        return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
    }

    padZero(number) {
        return number.toString().padStart(2, "0");
    }

    async getAllReservation(url, payload) {
        try {
            let response = await APIcallPOST(url, payload);
            let data = JSON.parse(response).data;
            let resDistinct = this.selectDistinct(data);
            await this.getMoreInfo(resDistinct);
        }
        catch (error) {
            console.error(error);
            throw error; // Renvoyer l'erreur pour la gérer en amont si nécessaire
        }
    }

    async getMoreInfo(reservations) {
        // Ajouter les informations utilisateur et du matériel
        for (const res of reservations) {
            let userInfos = await this.getUserInfos(res.login);
            res.userInfos = userInfos;
            let materials = await this.getMaterials(res.id_res);
            res.material = materials;
            let room = await this.getResRoom(res.id_res);
            res.room = room;
        }

        this.allRes = reservations;
    }

    async getUserInfos(login) {
        const l_url = "https://asaed4.gremmi.fr/api/user/list";
        const l_payload = { "login": login };

        try {
            const response = await APIcallPOST(l_url, l_payload);
            const data = JSON.parse(response).data;
            if (data.length > 0) {
                let res = data[0];
                res.classes = await this.getUserClasses(login);
                return res; // Renvoyer le premier élément du tableau
            } else {
                return null; // Ou renvoyer null si aucun résultat n'est trouvé
            }
        } catch (error) {
            console.error(error);
            throw error; // Renvoyer l'erreur pour la gérer en amont si nécessaire
        }
    }

    async getUserClasses(login) {
        const l_url = "https://asaed4.gremmi.fr/api/user/list";
        const l_payload = { "login": login, "allclass":true };
        try {
            const response = await APIcallPOST(l_url, l_payload);
            const data = JSON.parse(response).data;
            if (data.length > 0) {
                return data
            }
            else {
                return null;
            }
        }
        catch (error) {
            console.error(error);
            throw error;
        }
    }

    async getMaterials(id_res) {
        const l_url = "https://asaed4.gremmi.fr/api/material/list";
        const l_payload = { "id_res": id_res};
        try {
            const response = await APIcallPOST(l_url, l_payload);
            const data = JSON.parse(response).data;
            if (data.length > 0) {
                return data
            }
            else {
                return null;
            }
        }
        catch (error) {
            console.error(error);
            throw error;
        }
    }

    getCorrectClassName(classes) {
        if (Array.isArray(classes) && classes.length > 0) {
            // Filtrer les classes qui correspondent à la syntaxe spécifiée
            var filteredClasses = classes.filter(function(classObj) {
                return /^S\d[A-D]\d$/.test(classObj.name_class);
            });

// Trier les classes par le nombre de semestres de manière décroissante
            filteredClasses.sort(function(a, b) {
                var semestersA = parseInt(a.name_class.substring(1, 2));
                var semestersB = parseInt(b.name_class.substring(1, 2));
                return semestersB - semestersA;
            });

// Obtenir la classe avec le nombre de semestres le plus élevé
            var highestSemesterClass = filteredClasses[0].name_class;

            return highestSemesterClass; // Affiche "S4D2"
        }
        else {
            return null;
        }

    }

    selectDistinct(res) {
        let resDistinct = [];
        let stockId = [];
        res.forEach((el) => {
            if (stockId.indexOf(el.id_res) == -1) {
                resDistinct.push(el);
                stockId.push(el.id_res);
            }
            else {
                // console.log("salut à tous");
            }
        })
        return resDistinct;
    }

    async getResRoom(id_res) {
        const l_url = "https://asaed4.gremmi.fr/api/room/list";
        const l_payload = {"id_res": id_res};
        try {
            const response = await APIcallPOST(l_url, l_payload);
            const data = JSON.parse(response).data;
            if (data.length > 0) {
                return data
            }
            else {
                return null;
            }
        }
        catch (error) {
            console.error(error);
            throw error;
        }
    }

    updateResStatusEvent(btnValid, id_res, status) {
        btnValid.addEventListener('click',()=>{
            let l_url = "https://asaed4.gremmi.fr/api/reservation/update";
            let l_payload = {"id_res" : id_res, "id_status":status}
            APIcallPOST(l_url,l_payload)
                .then(
                    location.reload()
                )
                .catch((error) => {
                    // Gérer les erreurs ici
                    console.error(error);
                });
        })
    }

    async getResDate(url, payload) {
        try {
            let response = await APIcallPOST(url, payload);
            let data = JSON.parse(response).data;
            let resDistinct = this.selectDistinct(data);
            if (resDistinct.length > 0) {
                let date = {date_begin : resDistinct[0].date_begin, date_end : resDistinct[0].date_end};
                return date
            }
            else {
                return null;
            }
        }
        catch (error) {
            console.error(error);
            throw error; // Renvoyer l'erreur pour la gérer en amont si nécessaire
        }
    }

}