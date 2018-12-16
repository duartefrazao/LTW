function fill(Value) {
    let search = document.getElementById("searchInput");
    let display = document.getElementById("displaySuggestions");
    search.value = Value;
    display.innerHTML = "";
}

function removePrevious() {
    if (currentFocus < 1 || currentFocus==null) return;
    let previousSelection = document.querySelector("#displaySuggestions ul li:nth-child(" + currentFocus + ")");

    if(previousSelection)
        previousSelection.classList.remove("autocomplete-selection");
}

let search = document.getElementById("searchInput");
let display = document.getElementById("displaySuggestions");
let form = document.getElementById("search");

let currentFocus = 0;
let lastInput;

search.addEventListener("keydown", function (e) {
    removePrevious();
    let sugs = document.querySelectorAll("#displaySuggestions li")
    if (e.keyCode == 40) {
        currentFocus = (currentFocus + 1) % (sugs.length + 1);
    } else if (e.keyCode == 38) {
        if(currentFocus ==0)currentFocus = sugs.length;
        else currentFocus = (currentFocus - 1) % (sugs.length + 1);
    } else if (e.keyCode == 13) {
        if (currentFocus == 0) {
            form.submit();
            return;
        } else {
            e.preventDefault();
            let searchValue = document.querySelector("#displaySuggestions ul li:nth-child(" + currentFocus + ")");
            searchValue.click();
            form.submit();
        }
    }
    let current = document.querySelector("#displaySuggestions ul li:nth-child(" + currentFocus + ")");
    if (current != null)
        current.classList.add("autocomplete-selection")

})

function encodeForAjax(data) {
    return Object.keys(data)
        .map(function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
        })
        .join('&')
}
document.querySelector('#displaySuggestions').addEventListener("click", function (e) {
    //form.submit();
})

document.addEventListener('click', function(e){
    display.innerHTML = "";
} )

search.addEventListener("keyup", function () {
    let name = search.value;
    if (lastInput != name) {
        lastInput = name;
        currentFocus = 0;
    } else
        return;
    if (name == "") {
        display.innerHTML = "";
    } else {
        let request = new XMLHttpRequest();
        request.addEventListener("load", function () {
            let info = JSON.parse(this.response);
            let inner = "<ul>";
            info.channels.forEach(function(s){
                inner+="<li onclick=fill(\""+s.title + "\") ><a>c/"+ s.title+"</a></li>";
            })

            info.users.forEach(function(s){
                inner+="<li onclick=fill(\""+s.username + "\") ><a >u/"+ s.username+"</a></li>";
            });

            inner += "<ul>";

            display.innerHTML=inner;
        })

        request.open("post", "../actions/action_get_suggestions.php", true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(encodeForAjax({
            search: name
        }));
    }
})