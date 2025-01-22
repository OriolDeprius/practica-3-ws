function botons() {
    if (!localStorage.getItem('token')) {
        document.querySelector('.btn-activitats').setAttribute('disabled', 'true')
        document.querySelector('.btn-test').setAttribute('disabled', 'true')
    }
    else {
        document.querySelector('.btn-activitats').removeAttribute('disabled')
        document.querySelector('.btn-test').removeAttribute('disabled')
    }
}

document.querySelector('.btn-token').addEventListener('click', () => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let token = JSON.parse(xhr.responseText).token;
            localStorage.setItem('token', token);
            botons();
        }
    }

    xhr.open("GET", "/practica-3-ws/API/GetToken/Pràctica-WS");

    xhr.send();

});

document.querySelector('.btn-activitats').addEventListener('click', () => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.querySelector('.sortida-json').innerHTML = xhr.responseText;
        }
    }

    xhr.open("GET", "/practica-3-ws/API/Activitats");

    xhr.setRequestHeader('X-Authorization', localStorage.getItem('token'));

    xhr.send();

});

window.onstorage = e => {
    if (e.key == null && e.newValue == null) {
        botons();
    }
}

botons();