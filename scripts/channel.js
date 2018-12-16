let sub_button = document.querySelector(".sub-button");
let channel = localStorage.channel;
let csrf = localStorage.csrf;

localStorage.removeItem("channel");

sub_button.addEventListener("click",function(e){
    createRequest(receiveSubscription, '../actions/action_subscribe.php', getSubscriptionData());
});

function receiveSubscription(e){
    let response = JSON.parse(this.responseText);

    if(response.data === false){
        sub_button.classList.remove("subbed");
    }
    else{
        sub_button.classList.add("subbed");
    }
}

function getSubscriptionData() {

   let alreadySubscribed = sub_button.classList.contains("subbed");
    return {
        alreadySubscribed: alreadySubscribed,
        channel : channel,
        csrf:csrf
    };

}