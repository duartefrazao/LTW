let botao_settings = document.getElementById("settings_button");
let informacao = document.getElementById("information");
botao_settings.addEventListener("click",onSettingsClick);

function onSettingsClick(e)
{
    informacao.innerHTML="";
    let request = new XMLHttpRequest();
    request.addEventListener("load",change_to_settings);
}

function change_to_settings(e)
{

}