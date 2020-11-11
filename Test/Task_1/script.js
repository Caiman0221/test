autoEnter();

function autoEnter() {
    console.log('autoEnterTry');
    if (localStorage.getItem('login') === null) return;
    if (localStorage.getItem('password') === null) return;

    let login = localStorage.getItem('login');
    let password = localStorage.getItem('password');

    let url = "./enter.php";
    let body = new FormData();
    body.append("login", login);
    body.append("password", password);
    body.append("sha","true");

    fetch(url, {
        method: "POST",
        body: body
    })
    .then(response => response.json())
    .then(result => {
        fetchResultTrue(result)
    })
}

function enterButtonClick() {
    document.getElementById('regBlockContainer').classList.add('hidden');
    document.getElementById('enterBlockContainer').classList.remove('hidden');
}

function regButtonClick() {
    document.getElementById('enterBlockContainer').classList.add('hidden');
    document.getElementById('regBlockContainer').classList.remove('hidden');
}

function enterClick() {
    enterForm = document.enterForm;
    if (enterForm.login.value == '') {
        alert('Вы не ввели имя');
        return
    }
    if (enterForm.password.value == '') {
        alert('Вы не ввели пароль');
        return
    }

    let url = './enter.php';
    fetch(url, {
        method: 'POST',
        body: new FormData(enterForm)
    })
    .then(response => response.json())
    .then(result => {
        if (result[`result`] == "false") {
            alert(result[`text`]);
        } else {
            fetchResultTrue(result)
        }
    })

}

function regClick() {
    regForm = document.regForm;

    if (regForm.name.value == '') {
        alert('Вы не ввели имя');
        return
    }
    if (regForm.login.value == '') {
        alert('Вы не ввели логин');
        return
    }
    if (regForm.password.value == '') {
        alert('Вы не ввели пароль');
        return;
    }
    if (regForm.repeat_password.value == '') {
        alert('Вы не повторили пароль');
        return
    }
    if (regForm.password.value !== regForm.repeat_password.value) {
        alert('Пароли не совпадают');
        return
    }
    if (regForm.password.value.length < 8) {
        alert('Пароль должен быть больше 8 символов');
        return;
    }

    let url = './reg.php';
    fetch(url, {
        method: 'POST',
        body: new FormData(regForm)
    })
    .then(response => response.json())
    .then(result => {
        if (result[`result`] == 'false') {
            alert(result[`text`]);
        } else {
            fetchResultTrue(result)
        }
    });


}


function fetchResultTrue(result) {
    document.getElementById('successContent').innerHTML = result[`text`];
    localStorage.setItem('login',result[`login`]);
    localStorage.setItem('password',result[`password`]);
    document.getElementById('enterBlock').classList.add('hidden');
    document.getElementById('success').classList.remove('hidden');
}

function exitButton() {
    localStorage.clear();
    document.getElementById('successContent').innerHTML = '';
    document.getElementById('success').classList.add('hidden');
    document.getElementById('enterBlock').classList.remove('hidden');
}
