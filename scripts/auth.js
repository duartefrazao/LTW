let loginbutton = document.querySelector('#login-button');
loginbutton.addEventListener('click', function (event) {
    event.preventDefault();
    login(this);
});

let signupbutton = document.querySelector('#signup-button');
signupbutton.addEventListener('click', function (event) {
    event.preventDefault();
    signup(this);
});

let span = document.createElement('span');
span.classList.add('warning');

function removeWarningOnKeyPress(form, element){

    element.addEventListener('keypress',function(e){

        if(form.querySelector('.warning') != null)
            form.removeChild(form.querySelector('.warning'));
    
        if(element.classList.contains('shake'))
            element.classList.remove('shake');
    });
}



function signup(event) {
    draw_signup();

    let file = document.querySelector("input[type=file]");
    let fileDisplay = document.querySelector(".fileContainer");
    file.addEventListener("change",function(e){
        fileDisplay.firstChild.data = file.files[0].name;
    });

    send_input('#signup');
}


function login(event) {
    draw_login();
    send_input('#login');
}

function send_input(type) {

    let form = document.querySelector('.auth_form');

    form.addEventListener('submit', function (event) {

        event.preventDefault();

        switch (type) {
            case '#signup':

                let request = new XMLHttpRequest();
                request.addEventListener('load', signUpValidation);
                request.open('post', '../actions/action_signup.php', true);
                let formData = new FormData(document.querySelector('.auth_form'));
                request.send(formData);
                break;
            case '#login':
                createRequest(loginValidation, '../actions/action_login.php', {
                    username: form.elements['username'].value, 
                    password: form.elements['password'].value
                });
                
            default:
                break;
        }
    });
};

function signUpValidation(event) {
    
    let response = JSON.parse(this.responseText);

    let form = document.querySelector('.auth_form');

    if(response.type === true){
        removeSignUp();
        location.reload();
        return;
    }
    // if there already is an error showing
    else if(form.querySelector('.warning') != null)
        return;

    let username = form.querySelector('input[name="username"]');

    removeWarningOnKeyPress(form, username);

    let mail = form.querySelector('input[name="mail"]');

    removeWarningOnKeyPress(form, mail);

    let password = form.querySelector('input[name="password"]');

    span.textContent = response.content;;

    switch(response.type){
        case 'error_username':
            form.insertBefore(span, mail);
            username.classList.add('shake');
            break;
        case 'error_mail':
            form.insertBefore(span, password);
            mail.classList.add('shake');
            break;
    }

    return;

    
}

function loginValidation(event){
    let response = JSON.parse(this.responseText);

    let form = document.querySelector('.auth_form');    

    if(response.type === true){
        removeLogin();
        location.reload();
    }
    // if there already is an error showing
    else if(form.querySelector('.warning') != null)
        return;

    let username = form.querySelector('input[name="username"]');

    removeWarningOnKeyPress(form, username);

    let password = form.querySelector('input[name="password"]');

    removeWarningOnKeyPress(form, password);

    span.textContent = response.content;

    form.insertBefore(span, form.querySelector('.submit-button'));
    username.classList.add('shake');
    password.classList.add('shake');

    return;
}

function draw_mask(remove) {
    let blur = document.createElement('div');
    blur.setAttribute('id', 'mask');
    document.querySelector('body').insertBefore(blur, document.querySelector('header'));
    blur.addEventListener('click', function (event) {
        removeElement('#mask');
        removeElement(remove);
    })
}

function removeLogin(){
    removeElement('#mask');
    removeElement('#login');
}

function removeSignUp(){
    removeElement('#mask');
    removeElement('#signup');
}

function removeElement(element) {
    document.querySelector(element).remove();
}

function draw_signup() {
    draw_mask('#signup');
    let section = document.createElement('section');
    section.setAttribute('id', 'signup');
    section.innerHTML += '<header> <h1> Sign Up </h1> </header>' +
        '<form class="auth_form" enctype= multipart/form-data>' +
        '<input type="text" name="username" placeholder="username" required>' +
        '<input type="text" name="mail" placeholder="mail" required>' +
        '<input type="password" name="password" placeholder="password" required>' +
        '<input type="text" name="description" placeholder="Brief description of yourself">' +
        '<input type="text" name="title" placeholder="Image Title">' +
        '<label class="fileContainer"> Image' + 
        '<input type="file" title=" " name="image" placeholder="Your image">' +
        '</label>'+
        '<input class="submit_button" type="submit" value="Signup">' +
        '</form>';
    let footer = document.createElement('footer');
    let change = document.createElement('a');
    change.setAttribute('id', 'change_login');
    change.textContent = "Log in Here!";
    change.addEventListener('click', function (event) {
        removeElement('#signup');
        removeElement('#mask');
        login();
    })
    footer.appendChild(change);
    section.appendChild(footer);
    document.querySelector('body').appendChild(section);
}

function draw_login() {
    draw_mask('#login');
    let section = document.createElement('section');
    section.setAttribute('id', 'login');
    section.innerHTML += '<header> <h1> Log In</h1> </header>';
    section.innerHTML += '<form class="auth_form"> <input type="text" name="username" placeholder="username" required>' +
        '<input type="password" name="password" placeholder="password" required>' +
        '<input class="submit_button" type="submit" value="Login"></form>';
    let footer = document.createElement('footer');
    let change = document.createElement('a');
    change.setAttribute('id', 'change_signup');
    change.textContent = "Sign up here!";
    change.addEventListener('click', function (event) {
        removeElement('#login');
        removeElement('#mask');
        signup();
    })
    footer.appendChild(change);
    section.appendChild(footer);
    document.querySelector('body').appendChild(section);
}

function createRequest(handler, url, data) {
    let request = new XMLHttpRequest();
    request.addEventListener('load', handler);
    request.open('post', url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax(data));
    return request;
}

function encodeForAjax(data) {
    return Object.keys(data)
        .map(function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
        })
        .join('&')
}