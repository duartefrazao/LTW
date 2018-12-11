function fill(Value) {
    console.log("here")
    let search = document.getElementById("searchInput");
    let display = document.getElementById("displaySuggestions");

    search.value = Value;
    display.innerHTML = "";
}

function removePrevious() {
    if (currentFocus < 1) return;
    let previousSelection = document.querySelector("#displaySuggestions ul li:nth-child(" + currentFocus + ")");
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
        currentFocus = (currentFocus - 1) % (sugs.length + 1);
    } else if (e.keyCode == 13) {
        if (currentFocus == 0) {
            form.submit();
            return;
        } else {
            e.preventDefault();
            let searchValue = document.querySelector("#displaySuggestions ul li:nth-child(" + currentFocus + ") a").text;
            search.value = searchValue;
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
form.addEventListener("click", function (e) {
    if (e.target.nodeName == "LI") {
        form.submit();
    }
})
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
            let info = this.response;
            display.innerHTML = info
        })

        request.open("post", "../actions/action_get_suggestions.php", true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(encodeForAjax({
            search: name
        }));
    }
})