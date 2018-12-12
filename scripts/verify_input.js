
let login =document.querySelector('#login .auth_form'); 
login.addEventListener('submit', function(event){
    event.preventDefault();
    verifyInput(this);
});



function verifyInput(event){

    console.log(event);

}