
// =============== EVENT LISTENERS =================== //

let commentForm = document.querySelector('#post form');
commentForm.addEventListener('submit', function (event) {
  event.preventDefault();
  submitComment(this);
});


let replies = document.querySelectorAll('.numReplies');
replies.forEach(function(elem){
  elem.addEventListener('click', function(event){
    event.preventDefault();
    loadChildren(this);
  })
});

let loading = document.querySelector('.load-more');
loading.addEventListener('click', function (event) {
  event.preventDefault();
  loadReplies(this);
});

function addVoteListeners(element) {
  let votes = element.querySelectorAll('.vote');
  votes.forEach((vote) => vote.addEventListener('click', voteHandler));
}

function addRepliesListener(element) {
  let replies = element.querySelector('.numReplies');
  replies.addEventListener('click', function (event) {
    event.preventDefault();
    loadChildren(this);
  });
}



//==============================================================//


//============================MULTILEVEL=======================//


function loadChildren(element) {

  let parent_id = element.parentNode.querySelector('.voting_section').getAttribute('data-id');

  let lastReply = element.parentNode.querySelector('.replies .comment:last-of-type');

  let lastReplyId = lastReply === null ? Number.MAX_SAFE_INTEGER : lastReply.querySelector('aside').getAttribute('data-id');

  let request = new XMLHttpRequest();
  request.addEventListener('load', receiveReplies);
  request.open('post', '../actions/action_get_replies.php', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.send(encodeForAjax({
    parent_id: parent_id,
    last_id: lastReplyId
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

    let parent = document.querySelector('[data-id="' + parent_id + '"]').parentNode;
    let replies = document.createElement('span');
    replies.classList.add('replies');

    for (let i = 0; i < comments.length; i++) {

      let comment = createComment(comments[i]);

      addVoteListeners(comment);

      addRepliesListener(comment);

      replies.appendChild(comment);

    }

    parent.appendChild(replies);
  }
}

//=========================================================================//

//==========================='INFINITE SCROLLING'===========================//


function loadReplies(element) {

  let parent_id = (element.parentNode).querySelector('input[name=id]').value;

  let lastComment = document.querySelector('#post .comment:last-of-type');

  let last_id = lastComment.querySelector('aside').getAttribute('data-id');

  let request = new XMLHttpRequest();
  request.addEventListener('load', receiveComment);
  request.open('post', '../actions/action_get_replies.php', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.send(encodeForAjax({
    parent_id: parent_id,
    last_id: last_id
  }));
};

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

    addVoteListeners(comment);

    addRepliesListener(comment);

    section.appendChild(comment);
  }
}


//======================================================================//



//==============================ADD COMMENT=============================//


function submitComment(element) {

  let text = element.querySelector('textarea').value;

  element.querySelector('textarea').value = "";

  let parent_id = element.querySelector('input[name=id]').value;

  let comment_id = document.querySelector('#post .comment') != null ?
    document.querySelector('#post .comment:first-of-type aside')
    .getAttribute('data-id') :
    -1;

  let request = new XMLHttpRequest();
  request.addEventListener('load', addComment);
  request.open('post', '../actions/action_add_comment.php', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.send(encodeForAjax({
    parent_id: parent_id,
    text: text,
    comment_id: comment_id
  }));
}

function addComment(event) {

  let response = JSON.parse(this.responseText);

  if (response.result === false) {
    window.location = "../pages/login.php";
    return;
  }

  let comments = response.data;

  let section = document.querySelector('#comments');
  for (let i = 0; i < comments.length; i++) {

    let comment = createComment(comments[i]);

    addVoteListeners(comment);

    addRepliesListener(comment);

    section.insertBefore(comment, section.querySelector('#comments .comment:first-of-type'));
  }
}



//======================================================================//


//============================UTILITIES==========================//

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
    '<span class="numReplies">' + element.numComments + ' Repl' + (element.numComments == 1 ? 'y' : 'ies') + '</span';

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
    console.warn('on error:', comment.querySelector('img'));
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