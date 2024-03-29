let tx = document.getElementsByTagName('textarea');
for (let i = 0; i < tx.length; i++) {
  tx[i].setAttribute('style', 'height:' + (tx[i].scrollHeight) + 'px;overflow-y:hidden;');
  tx[i].addEventListener("input", OnInput, false);
}

function OnInput() {
  this.style.height = 'auto';
  this.style.height = (this.scrollHeight) + 'px';
}

//=============== COLLAPSE COMMENTS ================= //

let com_headers = document.querySelectorAll('.comment header');
com_headers.forEach(function(elem){
  elem.addEventListener('click', function(event){
    collapseChildren(this);});
});
  
let com_content = document.querySelectorAll('.comment .content');
com_content.forEach(function(elem){
  elem.addEventListener('click', function(event){
    collapseChildren(this);});
});

function addCollapseListener(element){
  element.querySelector('header')
  .addEventListener('click', function(event){
      collapseChildren(this);});

  element.querySelector('.content')
  .addEventListener('click', function(event){
      collapseChildren(this);});
}

function collapseChildren(element){
  let parent = element.parentNode;

  let replies = parent.querySelector('.replies');

  if( replies != null){
    parent.removeChild(replies);
  }
  removeTextArea(parent);
}

function removeTextArea(parent){
  let textArea = parent.querySelector('.reply-text-area');
  if( textArea != null){
    parent.removeChild(textArea);
  }
}



// =============== EVENT LISTENERS =================== //

window.onload = loadReplies(document.querySelector('.load-more'));

let commentForm = document.querySelector('#post > form');
commentForm.addEventListener('submit', function (event) {
  event.preventDefault();
  submitComment(this);
});

let loading = document.querySelector('.load-more');
loading.addEventListener('click', function (event) {
  event.preventDefault();
  loadReplies(this);
});


function addCreateReplyForm(element){
  element.querySelector('.reply').addEventListener('click', function(event){
    event.preventDefault(); 
    createReplyForm(this);
  });
};

function addMultiLevelListener(element){
  element.addEventListener('submit', function (event) {
    event.preventDefault();
    submitLeveledComment(this);
});
}

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

  createRequest(addComment, '../actions/action_add_comment.php', {parent_id: parent_id,text: text,comment_id: comment_id,csrf:localStorage.getItem('csrf'), post_id: parent_id});

}


function submitLeveledComment(element){

  let parent = element.parentNode;

  let post_id = document.querySelector('#post input[name="id"]').value;

  let text = element.querySelector('textarea').value;
  
  element.querySelector('textarea').value = "";
  
  let parent_id = getCommentId(parent);
  
  parent.removeChild(element);

  let replies = parent.querySelector('.replies');

  let comment_id = -1;

  if(replies != null){

  let first_comment = replies.querySelector('.comment :first-of-type');
   
  comment_id = getCommentId(first_comment);
  }
  createRequest(addExpandedComment, '../actions/action_add_comment.php',{parent_id: parent_id,text: text,comment_id: comment_id,csrf:localStorage.getItem('csrf'), post_id : post_id});

  

}



function addComment(event) {

  let response = JSON.parse(this.responseText);

  if (response.result === false) {
    login();
    return;
  }

  let comments = response.data;
  let extensions = response.extensions;

  let section = document.querySelector('#comments');
  for (let i = 0; i < comments.length; i++) {

    let comment = createComment(comments[i],extensions[i]);

    section.insertBefore(comment, section.querySelector('#comments .comment:first-of-type'));
  }
}




function addExpandedComment(event){

  let response = JSON.parse(this.responseText);

  if (response.result === false) {
    login();
    return;
  }

  let comments = response.data;
  let extensions = response.extensions;

  if (comments.length === 0) {
    return;
  } 
  
  let parent_id = comments[0].parentEntity;
  let parent = document.querySelector('[data-id="' + parent_id + '"]').parentNode;

  let replies = parent.querySelector('.replies');

  for (let i = 0; i < comments.length; i++) {

    let comment = createComment(comments[i],extensions[i]);

      if( replies === null){
        replies = document.createElement('span');
        replies.classList.add('replies');
        parent.appendChild(replies);
      }

    parent.querySelector('.numReplies').textContent

    replies.insertBefore(comment, replies.querySelector('.comment:first-of-type'));
  }
}





function createReplyForm(element){

  let comment = element.parentNode.parentNode;

  let comment_id = comment.querySelector('aside').getAttribute('data-id');

  let form = document.createElement('form');
  form.classList.add('reply-text-area');

  form.innerHTML = '<textarea name="text" required></textarea>' +
                   '<input type="hidden" name="id" value="' + comment_id + '">';

 let button = document.createElement('button');
 button.setAttribute('type', 'button');
 button.textContent = "Close";
  form.appendChild(button);
                   
  form.innerHTML += '<input type="submit" value="Reply">';

  addMultiLevelListener(form);

  form.querySelector('button').addEventListener('click', function(event) {
    removeTextArea(this.parentNode.parentNode);
  });

  comment.appendChild(form);

}


//=========================================================================//

//==========================='INFINITE SCROLLING'===========================//


function loadReplies(element) {

  let parent_id = (element.parentNode).querySelector('input[name=id]').value;

  let last_id = Number.MAX_SAFE_INTEGER;

  let lastComment = document.querySelector('#comments > .comment:last-of-type');

  if(lastComment != null)
    last_id = lastComment.querySelector('aside').getAttribute('data-id');

  createRequest(receiveComment,'../actions/action_get_replies.php', {parent_id: parent_id,last_id: last_id});
};

function receiveComment(event) {

  let response = JSON.parse(this.responseText);

  let comments = response.data;
  let extensions = response.extensions;

  let section = document.querySelector('#comments');

  for (let i = 0; i < comments.length; i++) {

    let comment = createComment(comments[i],extensions[i]);

    section.appendChild(comment);
  }
}



function loadChildren(element) {

  let parent = element.parentNode.parentNode;

  let parent_id = getCommentId(parent);

  let lastReply = parent.querySelector('[data-id="' + parent_id + '"] ~ .replies > .comment:last-of-type');

  let lastReplyId = lastReply === null ? Number.MAX_SAFE_INTEGER : lastReply.querySelector('aside').getAttribute('data-id');

  createRequest(receiveReplies, '../actions/action_get_replies.php',{parent_id: parent_id,last_id: lastReplyId});
}


function receiveReplies(event) {

  let response = JSON.parse(this.responseText);

  let comments = response.data;
  let extensions = response.extensions;

  if (comments.length === 0) {
    return;
  } 
  
  let parent_id = comments[0].parentEntity;
  let parent = document.querySelector('[data-id="' + parent_id + '"]').parentNode;

  let replies = parent.querySelector('.replies');

  if( replies === null){
    replies = document.createElement('span');
    replies.classList.add('replies');
    parent.appendChild(replies);
  }

    for (let i = 0; i < comments.length; i++) {

      let comment = createComment(comments[i],extensions[i]);

      replies.appendChild(comment);

    }

   
}





//======================================================================//


//============================UTILITIES==========================//

function getCommentId(element){
  return element.querySelector('aside').getAttribute('data-id');
}


function createComment(element,extension) {
  let comment = document.createElement('article');
  comment.classList.add('comment');

  let aside = document.createElement('aside');
  aside.classList.add('voting_section');
  aside.setAttribute('data-id', element.id);

  aside.innerHTML += '<section class="vote upvote' + (element.up == "true" ? ' upvote_triggered"' : '"') + '> </section>';

  aside.innerHTML += '<h5 class="votes">' + element.votes + '</h5>';

  aside.innerHTML += '<section class="vote downvote' + (element.up == "false" ? ' downvote_triggered"' : '"') +'</section>';
  
  comment.appendChild(aside);

  comment.innerHTML += ' <header> <a class="user-info" href="../pages/profile.php?user=' + element.username + '"> <h3 data-id="' + element.id +
  '" class="username">' +
  '<img class="small-image"  src="../images/users/default/default_small.png" >' + element.username + '</h3></a>' +
  '<h3 class="creationDate">' + humanTiming(element.creationDate) + '</h3> </header> <div class="vr"></div>' +
  '<h2 class="content">' + element.title + '</h2> <footer>' +
  '<span class="numReplies">' + element.numComments + ' Repl' + (element.numComments == 1 ? 'y' : 'ies') + '</span>' +
  '<span class="reply"> Reply </span> </footer>';

  checkUserImage(element.author, comment,extension);

  addCreateReplyForm(comment);

  addVoteListeners(comment);

  addRepliesListener(comment);
  
  addCollapseListener(comment);

  return comment;
}


function checkUserImage(id, comment,extension) {

  var image = new Image();

  let element = comment.querySelector('.small-image');

  image.onload = function () {
    // image exists and is loaded
    
    if(extension == "gif")
    {
      element.src = '../images/users/originals/' + id + '.' + extension;
      element.width=28;
      element.height=28;
      element.setAttribute("class","gif_small");
    }
    else
      element.src = '../images/users/thumb_small/' + id + '.' + extension;
  }
  image.onerror = function () {
    // image did not load
    console.warn('on error:', comment.querySelector('img'));
  }
  
  if(extension == "gif")
  {
    image.src = '../images/users/originals/' + id + '.' + extension;
    image.width=28;
    image.height=28;
    image.setAttribute("class","gif_small");
  }
  else
    image.src = '../images/users/thumb_medium/' + id + '.' + extension;
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


function createRequest(handler, url, data){
  let request = new XMLHttpRequest();
  request.addEventListener('load', handler);
  request.open('post', url, true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send(encodeForAjax(data));

  return request;
}

function encodeForAjax(data) {
  return Object.keys(data)
    .map(function (k) {
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    })
    .join('&')
}