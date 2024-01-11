// TODO: use token for secure call to the API
var token = 'none';

async function APIcallGET(url) {
    let req = new Request(url, {
        method: 'GET',
        headers: new Headers({
            'Content-Type': 'application/json'
        })
    });
    return APIcall(req);
}

async function APIcallPOST(url, payload) {
    let req = new Request(url, {
        method: 'POST',
        body: JSON.stringify(payload),
        headers: new Headers({
            'Content-Type': 'application/json'
        })
    });
    return APIcall(req);
}

async function APIcall(request) {
    return new Promise((resolve, reject) => {
        fetch(request).then((res) => {
            if (res.ok) {
                res.text().then((text) => {
                    resolve(text);
                }).catch((err) => {
                    reject(`Unable to parse response: ${JSON.stringify(err)}`);
                });
            } else {
                reject(`Unable to parse response: ${JSON.stringify(res)}`);
            }
        }).catch((err) => {
            reject(`Unable to reach API: ${JSON.stringify(err)}`);
        })
    })
}

function request(secid, ispost) {
    let url = '/api/';
    let uri = document.querySelector(`#${secid} > fieldset > input[name="uri"]`).value;
    let divres = document.querySelector(`#${secid} > .result`);
    divres.innerHTML = 'nothing yet...';


    let payload;
    try {
        payload = document.querySelector(`#${secid} > textarea.inlinejson`).value;
        console.log(payload)
        payload = JSON.parse(payload);
        console.log(payload)

    } catch (err) {
        payload = null;
    }

    let apicall = APIcallGET;
    if (ispost) { apicall = APIcallPOST; }

    apicall(`${url}${uri}`, payload).then((res) => {
        try {
            divres.innerHTML = JSON.stringify(JSON.parse(res));
        } catch (err) {
            divres.innerHTML = err + '<br><br><strong>Raw text received:</strong><br>' + res;
        }
    }).catch((err) => {
        divres.innerHTML = err;
    })
}

document.querySelectorAll('input[enter]').forEach((item) => {
    item.addEventListener("keyup", (evt) => {
        if (evt.key === "Enter") { request(evt.target.getAttribute('secid')); }
    })
})

function updateAuthentificationBadge(val) {
    if (val) {
        document.querySelector('#check').classList.remove('hide');
        document.querySelector('#cross').classList.add('hide');
    } else {
        document.querySelector('#check').classList.add('hide');
        document.querySelector('#cross').classList.remove('hide');
    }
}

function authentication() {
    updateAuthentificationBadge(false);
    let login = document.querySelector('input[name="login"]').value;
    let pwd = document.querySelector('input[name="pwd"]').value;
    let payload = { "login": login, "pwd": pwd };

    APIcallPOST('/api/TODO', payload).then((res) => {
        try {
            res = JSON.parse(res);
            // TODO
            // token = something
            updateAuthentificationBadge(res.data);
        } catch (err) {
            divres.innerHTML = err + '<br><br><strong>Raw text received:</strong><br>' + res;
        }
    }).catch((err) => {
        console.log(err);
    })
}

function invalidate() {
    APIcallPOST('/api/TODO').then((res) => {
        updateAuthentificationBadge(false);
        token = 'none';
    }).catch((err) => {
        console.log(err);
    })
}

function removeAllChildNodes(parent) {
    // Fonction qui supprime tous les éléments enfants de l'élément 'parent'
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}


