/* let searchBar = document.querySelector("#searchInput");
let arr = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

let currentFocus;

searchBar.addEventListener("input",function(e){
    var a, b, i, val = this.value;
      //close any already open lists of autocompleted values
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      //create a DIV element that will contain the items (values):
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //append the DIV element as a child of the autocomplete container:
      this.parentNode.appendChild(a);
      //for each item in the array...
      for (i = 0; i < arr.length; i++) {
        //check if the item starts with the same letters as the text field value:
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          //create a DIV element for each matching element:
          b = document.createElement("DIV");
          //make the matching letters bold:
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          //insert a input field that will hold the current array item's value:
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          //execute a function when someone clicks on the item value (DIV element):
              b.addEventListener("click", function(e) {
              //insert the value for the autocomplete text field:
              searchBar.value = this.getElementsByTagName("input")[0].value;
              // close the list of autocompleted values,
              //(or any other open lists of autocompleted values:
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
})

searchBar.addEventListener("keydown",function(e){
    let x = document.getElementById(this.id + "autocomplete-list");

    if(x)
        x=x.getElementsByTagName("div");
    
        if(e.keyCode ==40){
            currentFocus++;
            addActive(x);
        }else if(e.keyCode == 38){
            currentFocus--;
            addActive(x);
        }else if(e.keyCode == 13){
            e.preventDefault();
            if(currentFocus>-1){
                if(x)
                    x[currentFocus].click();
            }
        }
})

function addActive(el){
    if(!el)
        return;
    removeActive(el);

    if(currentFocus >= el.length)
        currentFocus=0;

    if(currentFocus < 0)
        currentFocus= el.length-1;
    
    el[currentFocus].classList.add("autocomplete-active");
    
};

function removeActive(els){
    for (var i = 0; i < els.length; i++) {
        els[i].classList.remove("autocomplete-active");
      }
}

function closeAllLists(el){
    let x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
        if (el != x[i] && el != searchBar) {
        x[i].parentNode.removeChild(x[i]);
      }}
}

document.addEventListener("click",function(e){
    closeAllLists(e.target);
}) */

//searchInput displaySuggestions

function fill(Value){
    console.log("here")
    let search = document.getElementById("searchInput");
    let display = document.getElementById("displaySuggestions");

    search.value = Value;
    display.innerHTML = "";
}

function removePrevious(){
    if(currentFocus<1) return;
    let previousSelection = document.querySelector("#displaySuggestions ul li:nth-child(" + currentFocus + ")");
    previousSelection.classList.remove("autocomplete-selection");
}

let search = document.getElementById("searchInput");
let display = document.getElementById("displaySuggestions");
let form = document.getElementById("search-channel");

let currentFocus = 0;
let lastInput;

search.addEventListener("keydown",function(e){
    console.log(e.keyCode)
    removePrevious();
    let sugs = document.querySelectorAll("#displaySuggestions li")
    if(e.keyCode ==40){
        currentFocus = (currentFocus +1) % (sugs.length +1);   
    }else if(e.keyCode==38){
        currentFocus = (currentFocus - 1) % (sugs.length +1);
    }else if(e.keyCode == 13){
        if(currentFocus ==0){
            form.submit();
            return;}
        else{
        e.preventDefault();
        let searchValue = document.querySelector("#displaySuggestions ul li:nth-child(" + currentFocus + ") a").text;
        search.value = searchValue;
        form.submit();
        }
    }
    let current = document.querySelector("#displaySuggestions ul li:nth-child(" + currentFocus + ")");
    if(current != null)
        current.classList.add("autocomplete-selection")

})
function encodeForAjax(data) {
    return Object.keys(data)
        .map(function(k) {
          return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
        })
        .join('&')
  }
form.addEventListener("click",function(e){
    console.log(e.target.nodeName=="LI")
    if(e.target.nodeName =="LI"){
        form.submit();}
})
search.addEventListener("keyup",function(){
    console.log("keyup");
    let name= search.value;
    if(lastInput != name){
        lastInput = name;
        currentFocus=0;
    }
    else 
        return ;
    if(name == ""){
        display.innerHTML="";
    }else{
        let request = new XMLHttpRequest();
        request.addEventListener("load", function(){
        let info = this.response;
        display.innerHTML = info
     })

    request.open("post", "../actions/action_get_suggestions.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({search: name}));
    }
})

