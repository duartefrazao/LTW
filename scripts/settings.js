let botao_settings = document.getElementById("settings_button");
let informacao = document.getElementById("information");
botao_settings.addEventListener("click",onSettingsClick);

function onSettingsClick(e)
{
    informacao.innerHTML="";
    createRequest(change_to_settings,"../actions/action_get_user_info.php",{});
}

function change_to_settings()
{
    let response = JSON.parse(this.responseText);
    let info = response.info;
    let section = document.createElement("section");
    section.setAttribute("id","settings");
    section.innerHTML = '<header><h1>Settings</h1></header> ';
    section.innerHTML +='<form class="setting" method="post" action="../actions/action_update_data.php" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">';
    section.innerHTML +='<input type="hidden" name="id" value="'+info.id+'">';
    let table = document.createElement("table");
    
    table.innerHTML +='<table><tr> <th>Image:</th><td>'+ draw_Image(info.id)+'</td><td><input src="" type="file" id="image" name="image" placeholder="Your image"></td></tr>';
    table.innerHTML +='<tr><th>Username:</th><td><input type="text" name="username" placeholder="New username" value="'+info.username+'" required></td></tr>';
    table.innerHTML +='<tr><th>E-mail:</th><td><input type="text" name="mail" placeholder="New e-mail" value="'+info.mail+'" required></td></tr>';
    table.innerHTML +='<tr><th>Description:</th><td><input type="text" name="description" placeholder="New description" value="'+info.description+'"></td></tr>';
    table.innerHTML +='<tr><th>New Pass:</th><td><input type="password" name="pass"></td></tr>';
    table.innerHTML +='<tr><th>Re-enter new pass:</th><td><input type="password" name="repass"></td></tr>';
    table.innerHTML +='<tr><td><input class="setting_button" type="submit" value="Save"></td></tr></table></form>';

    section.appendChild(table);
    informacao.appendChild(section);
    let image=document.getElementById('image');
    image.addEventListener("change",change_Image);
}

function change_Image(){
    let image = document.querySelector(".user-image");
    let image_load = document.getElementById("image");
    let reader = new FileReader();
    reader.readAsDataURL(image_load.files[0]);
    reader.onload = function(e) {
        image.setAttribute("src",e.target.result);
    };
}

function draw_Image(id){
    let image = "../images/users/thumb_medium/" + id + ".jpg";
    if(UrlExists(image))
        return '<img class="user-image" src="'+ image +'" width="46" height="46">';
    else
        return '<img class="user-image" src="../images/users/default/user_icon.png" width="16" height="16"></img>';
}

function UrlExists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
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