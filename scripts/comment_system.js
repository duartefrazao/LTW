let commentForm = document.querySelector('#post form');

commentForm.addEventListener('submit', function (event) {
  event.preventDefault();
  submitComment(this);
});


let replies = document.querySelector('.replies');
replies.addEventListener('click', function (event) {
  event.preventDefault();
  loadReplies(this);
});


function loadReplies(element) {

  let parent_id = element.parentNode.querySelector('.voting_section').getAttribute('data-id');

  let request = new XMLHttpRequest();
  request.addEventListener('load', receiveReplies);
  request.open('post', '../actions/action_get_replies.php', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.send(encodeForAjax({
    parent_id: parent_id
  }));
}

function receiveReplies(event) {


  let response = JSON.parse(this.responseText);

  if (response.result === false) {
    window.location = "../pages/login.php";
    return;
  }

  let comments = response.data;


  if (comments.length === 0) {
    return;
  } else {
    let parent_id = comments[0].parentEntity;

    console.log(parent_id);

    let parent = document.querySelector('[data-id="' + parent_id + '"]').parentNode;

    console.log(parent);
    for (let i = 0; i < comments.length; i++) {

      let comment = createComment(comments[i]);

      parent.appendChild(comment);


      const votes = parent.querySelectorAll('#comments article:last-child .vote')
      votes.forEach((vote) => vote.addEventListener('click', voteHandler));
    }
  }

}


function submitComment(element) {

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
  request.send(encodeForAjax({
    parent_id: parent_id,
    text: text,
    comment_id: comment_id
  }));
}

function receiveComment(event) {

  let response = JSON.parse(this.responseText);

  if (response.result === false) {
    window.location = "../pages/login.php";
    return;
  }

  let comments = response.data;

  let section = document.querySelector('#comments');
  for (let i = 0; i < comments.length; i++) {

    let comment = createComment(comments[i]);

    section.appendChild(comment);


    const votes = section.querySelectorAll('#comments article:last-child .vote')
    votes.forEach((vote) => vote.addEventListener('click', voteHandler));
  }
}


function createComment(element) {
  let comment = document.createElement('article');
  comment.classList.add('comment');
  comment.innerHTML = '<aside class="voting_section" data-id="' + element.id + '">' +
    '<section class="vote upvote"> </section>' +
    '<h5 class="votes">' + element.votes + '</h5>' +
    '<section class="vote downvote"> </section></aside>' +
    '<header> <h3 data-id="' + element.id +
    '" class="username">' +
    '<img class="user-image" src="../images/users/default/user_icon.png" width="16" height="16">' + element.username + '</h3>' +
    '<h3 class="creationDate">' + humanTiming(element.creationDate) + '</h3> </header>' +
    '<h2 class="content">' + element.title + '</h2>' +
    '<span class="replies">' + element.numComments + ' Repl' + (element.numComments == 1 ? 'y' : 'ies') + '</span';

  checkUserImage(element.author, comment);

  return comment;
}













function checkUserImage(id, comment) {

  var image = new Image();

  let element = comment.querySelector('.user-image');

  image.onload = function () {
    // image exists and is loaded
    element.src = '../images/users/thumb_small/' + id + '.jpg';
  }
  image.onerror = function () {
    // image did not load
    console.log('on error:', comment.querySelector('img'));
  }

  image.src = '../images/users/thumb_small/' + id + '.jpg';
}



function humanTiming(originalTime) {

  let time = Math.floor(Date.now() / 1000) - originalTime;
  time = (time < 1) ? 1 : time;

  let tokens = [{
      31536000: 'year'
    },
    {
      2592000: 'month'
    },
    {
      604800: 'week'
    },
    {
      86400: 'day'
    },
    {
      3600: 'hour'
    },
    {
      60: 'minute'
    },
    {
      1: 'second'
    }
  ];


  for (let pair of tokens) {

    key = Object.keys(pair)[0];

    if (time < key) continue;

    let numberOfUnits = Math.floor(time / key);

    return numberOfUnits + ' ' + pair[key] + ((numberOfUnits > 1) ? 's' : '');
  }
}




function encodeForAjax(data) {
  return Object.keys(data)
    .map(function (k) {
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    })
    .join('&')
}