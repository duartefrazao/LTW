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


function signup(event) {
    draw_signup();
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
                createRequest(signUpValidation, '../actions/action_signup.php', {
                    username: form.elements['username'].value, 
                    mail: form.elements['mail'].value,
                    password: form.elements['password'].value,
                    description: form.elements['description'].value,
                    title: form.elements['title'].value,
                    image: form.elements['image'].value
                });
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

    if(response.type === true){
        removeSignUp();
        location.reload();
    }
}

function loginValidation(event){
    let response = JSON.parse(this.responseText);

    if(response.type === true){
        removeLogin();
        location.reload();
    }
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
        '<form class="auth_form">' +
        '<input type="text" name="username" placeholder="username" required>' +
        '<input type="text" name="mail" placeholder="mail" required>' +
        '<input type="password" name="password" placeholder="password" required>' +
        '<input type="text" name="description" placeholder="Brief description of yourself">' +
        '<input type="text" name="title" placeholder="Image Title">' +
        '<input type="file" name="image" placeholder="Your image">' +
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