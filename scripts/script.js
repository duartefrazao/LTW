let commentForm = document.querySelector('#post form');

commentForm.addEventListener('submit', function(event) {
  event.preventDefault();
  submitComment(this);
});


function submitComment(element) {

  console.log(element);

  let text = element.querySelector('textarea').value;

  element.querySelector('textarea').value = "";

  let parent_id = element.querySelector('input[name=id]').value;

  let comment_id = document.querySelector('#post .comment') != null ?
      document.querySelector('#post .comment:last-of-type header h3')
          .getAttribute('data-id') :
      -1;

  let request = new XMLHttpRequest();
  request.addEventListener('load', receiveComment);
  request.open('post', '../actions/action_add_comment.php', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.send(encodeForAjax(
      {parent_id: parent_id, text: text, comment_id: comment_id}));
}

function encodeForAjax(data) {
  return Object.keys(data)
      .map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
      })
      .join('&')
}

function receiveComment(event) {
  let comments = JSON.parse(this.responseText);
  console.log(comments);
  let section = document.querySelector('#comments');
  for (let i = 0; i < comments.length; i++) {
    let comment = document.createElement('article');
    comment.classList.add('comment');
    comment.innerHTML = '<aside class="voting_section">' +
    '<a href="../actions/action_vote_post.php?id=' + comments[i].id + '&type=1">' + 
    '<section class="upvote"> </section> </a>' + 
    '<h5 class="votes">' + comments[i].votes + '</h5>' + 
    '<a href="../actions/action_vote_post.php?id=' + comments[i].id + '&type=-1">' + 
    '<section class="downvote"> </section> </a> </aside>'+
    '<span class="partial_line"> </span>'+
    '<header> <h3 data-id="' + comments[i].id +
        '" class="username">' +
        '<i class="fas fa-user-circle"></i> ' + comments[i].username + '</h3>' +
        '<h3 class="creationDate">' + humanTiming(comments[i].creationDate) + '</h3> </header>' +
        '<h2 class="content">' + comments[i].title + '</h2>';
    section.appendChild(comment);
  }
}


function humanTiming(originalTime) {
  let time = Math.floor(Date.now() / 1000) - originalTime;
  time = (time < 1) ? 1 : time;
  let tokens = {
    31536000: 'year',
    2592000: 'month',
    604800: 'week',
    86400: 'day',
    3600: 'hour',
    60: 'minute',
    1: 'second'
  };

  for (var key in tokens) {
    if (time < key) continue;

    let numberOfUnits = Math.floor(time / key);
    return numberOfUnits + ' ' + tokens[key] + ((numberOfUnits > 1) ? 's' : '');
  }
}




//================================VOTES=============================================


let upvote = document.querySelector(".upvoteLink");

console.log(upvote);

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