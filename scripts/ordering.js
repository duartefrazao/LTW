let firstDrop = document.querySelector("ul");
let elems = document.querySelectorAll("li");

let orderClasses= ["mostrecent","mostvoted","mostcommented"];
let order = "mostrecent";
let dropped = true;

elems.forEach((f) => f.addEventListener("click",function(e){
    order = orderClasses[f.value];
    firstDrop.innerHTML="";
    dropped=false;
})) 

firstDrop.addEventListener("click",function(e){
    console.log("here")
    if(!dropped)
     firstDrop.innerHTML = '<li value="0" >  Most Recent </li><li value="1">  Most Voted </li><li value="2">  Most Comments </li>';
})