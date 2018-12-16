const MAX_IMAGE_SIZE = 100000000;

let botao_settings = document.getElementById("settings_button");
let informacao = document.getElementById("information");
botao_settings.addEventListener("click",onSettingsClick);
let last_html=informacao.innerHTML;
let image_not_valid=false;


function onSettingsClick(e)
{
    informacao.innerHTML="";
    createRequest(change_to_settings,"../actions/action_get_user_info.php",{});
}

function change_to_settings()
{
    let response = JSON.parse(this.responseText);
    let image_exists = response.image;
    let info = response.info;
    informacao.setAttribute("id","settings");
    informacao.innerHTML = '<header><h1>Settings</h1></header> ';
    let form = document.createElement('form');
    form.setAttribute("class","setting");
    form.setAttribute("method","post");
    form.setAttribute("action","../actions/action_update_data.php");
    form.setAttribute("autocomplete","off");
    form.setAttribute("autocorrect","off");
    form.setAttribute("autocapitalize","off");
    form.setAttribute("spellcheck","false");
    form.setAttribute("enctype","multipart/form-data");
    form.innerHTML +='<input type="hidden" name="id" value="'+info.id+'">';
    let table = document.createElement("table");

    table.innerHTML +='<table id="settings_table"><tr> <th>Image:</th><td>'+ draw_Image(image_exists,info.id,response.extension)+'</td></tr>'
    table.innerHTML +='<tr><th></th></th><td><input src="" type="file" id="image_input" name="image" placeholder="Your image" multiple accept="image/jpeg,image/jpg,image/gif,image/png"></td></tr>';
    table.innerHTML +='<tr><th>Username:</th><td><input type="text" name="username" placeholder="New username" value="'+info.username+'" required></td></tr>';
    table.innerHTML +='<tr><th>E-mail:</th><td><input type="text" name="mail" placeholder="New e-mail" value="'+info.mail+'" required></td></tr>';
    table.innerHTML +='<tr><th>Description:</th><td><input type="text" name="description" placeholder="New description" value="'+info.description+'"></td></tr>';
    table.innerHTML +='<tr><th>New Pass:</th><td><input id="new_pass" type="password" name="pass"></td></tr>';
    table.innerHTML +='<tr><th>Re-enter new pass:</th><td><input id="new_repass" type="password" name="repass"></td></tr>';
    table.innerHTML +='<tr><td><input id="setting_button" type="submit" value="Save"><button id="cancel_button">Cancel</button></td><td><warning id="info"></warning></td></tr></table>';
    form.appendChild(table);
    informacao.appendChild(form);
    let image=document.getElementById('image_input');
    image.addEventListener("change",change_Image);
    
    let botao_cancel = document.getElementById("cancel_button");
    botao_cancel.addEventListener("click",cancel);
    let botao = document.getElementById("setting_button");
    botao.addEventListener("click",checkInfo);
}
function cancel(e){
    e.preventDefault();
    informacao.setAttribute("id","information");
    informacao.innerHTML=last_html;
    let change_settings = document.getElementById("settings_button");
    change_settings.addEventListener("click",onSettingsClick);
}

function checkInfo(e){
    let new_pass = document.getElementById("new_pass");
    let new_repass = document.getElementById("new_repass");
    let info = document.getElementById("info");
    if(new_pass.value != new_repass.value)
    {
        info.innerHTML="Password does not match";
        e.preventDefault();
    }
    if(image_not_valid)
    {
        info.innerHTML="Image is too big";
        e.preventDefault();
    }
}

function change_Image(){
    let image = document.querySelector(".user-image");
    let image_load = document.getElementById("image_input");
    let reader = new FileReader();
    let info = document.getElementById("info");
    let type = image_load.files[0].type.split("/")[1];
    if(image_load.files[0].size > MAX_IMAGE_SIZE && type == "gif"){
        image_not_valid=true;
        info.innerHTML="GIF is too big";
    }
    else
    {
        image_not_valid=false;
        if(info.innerHTML=="GIF is too big")
        {
            info.innerHTML="";
        }
    }
    if(type == "gif" || type == "jpeg" || type == "jpg" || type == "png")
    {
        image_not_valid=false;
        if(info.innerHTML=="Uploaded image format not valid")
        {
            info.innerHTML="";
        }
    }
    else
    {
        image_not_valid=true;
        info.innerHTML="Uploaded image format not valid";
    }
    reader.readAsDataURL(image_load.files[0]);
    reader.onload = function(e) {
        image.setAttribute("src",e.target.result);
    };
}

function draw_Image(image,id,extension){
    let image_url = "../images/users/originals/" + id + "." +extension;
    if(image == true)
        return '<img class="user-image" src="'+ image_url +'" width="100" height="100">';
    else
        return '<img class="user-image" src="../images/users/default/default.png" width="100" height="100"></img>';
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