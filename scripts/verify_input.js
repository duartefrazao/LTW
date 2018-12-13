
let login =document.querySelector('#login .auth_form'); 

if(login == null)
    login=document.querySelector('#signup .auth_form');


    function encodeForAjax(data) {
        return Object.keys(data)
            .map(function(k) {
              return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
            })
            .join('&')
      }
    
    

login.addEventListener('submit', function(event){
    event.preventDefault();
    let request = new XMLHttpRequest();
    request.addEventListener("load", function(){
         let info = JSON.parse(this.responseText);
        console.log(info);
    }); 

    request.open("post", "../actions/action_signup.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    console.log("Sending");
    request.send(encodeForAjax({
        username: login.elements['username'],
        mail:login.elements['mail'],
        password:login.elements['password'],
        description:login.elements['description'],
        title:login.elements['title'],
        image:login.elements['image']
    })); 
});

