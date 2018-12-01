
let upvote = document.querySelector(".upvoteLink");
console.log(upvote);
function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
  }
function voteReceived(){

}
upvote.addEventListener('click',function(event){
    console.log("here");
    event.preventDefault();
    const upType = 1;
    const id = document.querySelector(".overview-post  ")
    let request = new XMLHttpRequest();
    request.addEventListener("load", voteReceived);
    request.open("post", "database/api_vote.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({voteType: upType,entityID:id}));
    console.log("here2");
});


let downvote = document.querySelector(".downvoteLink");
console.log(downvote);
downvote.addEventListener('click',function(event){
    const downType = -1;
    event.preventDefault();
});