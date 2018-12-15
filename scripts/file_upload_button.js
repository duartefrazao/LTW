
let file = document.querySelector("input[type=file]");
let fileDisplay = document.querySelector(".fileContainer");
file.addEventListener("change",function(e){
    fileDisplay.firstChild.data = file.files[0].name;
});