
let loginbutton =document.querySelector('#login-button'); 
loginbutton.addEventListener('click', function(event){
    event.preventDefault();
    login(this);
});

let signupbutton = document.querySelector('#signup-button');
signupbutton.addEventListener('click', function(event) {
    event.preventDefault();
    signup(this);
});


function signup(event){

    draw_signup();
}


function login(event){

    draw_login();

}

function draw_signup(){

    draw_mask('#signup');

    let section = document.createElement('section');
    
    section.setAttribute('id', 'signup');


    section.innerHTML+= '<header> <h1> Sign Up </h1> </header>' +
                        '<form class="auth_form" method="post" action="../actions/action_signup.php"  enctype="multipart/form-data">' +
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
    
    change.addEventListener('click', function(event){

        removeElement('#signup');
        removeElement('#mask');
        login();

    })

    footer.appendChild(change);
    section.appendChild(footer);

    document.querySelector('body').appendChild(section);

}

function draw_login(){

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
    
    change.addEventListener('click', function(event){

        removeElement('#login');
        removeElement('#mask');
        signup();

    })

    footer.appendChild(change);
    section.appendChild(footer);

    document.querySelector('body').appendChild(section);

}

function draw_mask(remove){
    let blur = document.createElement('div');
    blur.setAttribute('id', 'mask');
    document.querySelector('body').insertBefore(blur, document.querySelector('header'));

    blur.addEventListener('click', function(event){
        removeElement('#mask');
        removeElement(remove);
    })
}


function removeElement(element){
    document.querySelector(element).remove();
}