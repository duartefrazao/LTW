let voteForms = document.querySelectorAll(".vote");
voteForms.forEach((voteInstance)=>voteInstance.addEventListener('click',voteHandler));

function voteHandler(event){

    let vote=event.target;
    let upvote=(vote.classList.contains("upvote")?'true':'false');

    let aside = event.path[1];
    let entityID = aside.getAttribute('data-id');
    
    let request = new XMLHttpRequest();
    request.addEventListener("load", function(){
      let info = JSON.parse(this.responseText);
      
      if(info.result===false){
        window.location = "../pages/login.php";
        return;
      }

      if(upvote==='true' && info.data['up']){
          vote.classList.add("upvote_triggered");
      }
      else if(upvote==='false' && info.data['up'] === 'false'){
          vote.classList.add("downvote_triggered")
      }else{
        aside.children[0].classList.remove("upvote_triggered")
        aside.children[2].classList.remove("downvote_triggered")
      }

      aside.children[1].innerHTML=info.data['votes'];
    });
    request.open("post", "../actions/action_vote_post.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({voteType: upvote,entityID:entityID}));
}



function encodeForAjax(data) {
    return Object.keys(data)
        .map(function(k) {
          return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
        })
        .join('&')
  }



function humanTiming(originalTime) {

  let time = Math.floor(Date.now() / 1000) - originalTime;
  time = (time < 1) ? 1 : time;

  let tokens = [
    {31536000: 'year'},
    {2592000: 'month'},
    {604800: 'week'},
    {86400: 'day'},
    {3600: 'hour'},
    {60: 'minute'},
    {1: 'second'}];


   for (let pair of tokens) {

    key = Object.keys(pair)[0];

    if (time < key) continue;

    let numberOfUnits = Math.floor(time / key);

    return numberOfUnits + ' ' + pair[key] + ((numberOfUnits > 1) ? 's' : '');
  }
}
