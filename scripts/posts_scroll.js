document.addEventListener('scroll', function () {
    checkForNewPosts();
  });

  document.querySelector('.select').addEventListener('click', function(event){
    changePostsOrder(this);
  });
  

  function  changePostsOrder(elem){

    let ordering = elem.value;

    let offset = Number.MAX_SAFE_INTEGER;

    document.querySelector('#posts').innerHTML = "";

    let request = new XMLHttpRequest();
      request.addEventListener('load', receivePost);
      request.open('post', '../actions/action_get_posts.php', true);
      request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
      request.send(encodeForAjax({lastId: -1, offset: offset, criteria: ordering}));


  }


  function getOffsetToOrder(lastPost){

    let ordering = document.querySelector('.select').value;

    let terms = ordering.split('-');

    let id = lastPost.querySelector('aside').getAttribute('data-id');

    let value = 0;

    switch(terms[0]){

      case 'mostrecent':
        value = id;
        break;
      case 'mostvoted':
        value = lastPost.querySelector('aside .votes').textContent;
        break;
      case 'mostcommentd':
        value = lastPost.querySelector('.comments a').value;
        break;
    }

    return { lastId: id, offset: value , criteria: ordering};

  }


  function checkForNewPosts() {
    let lastPost = posts.querySelector('#posts .overview-post:last-of-type');
  
    let lastPostOffset = lastPost.offsetTop + lastPost.clientHeight;
  
    let pageOffset = window.pageYOffset + window.innerHeight;
  
    if (pageOffset > lastPostOffset  + 10) {

      let request = new XMLHttpRequest();
      request.addEventListener('load', receivePost);
      request.open('post', '../actions/action_get_posts.php', true);
      request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
      request.send(encodeForAjax(getOffsetToOrder(lastPost))) 
      
    }
  };

function receivePost(event){
  let response = JSON.parse(this.responseText);

  let posts = response.data;

  let section = document.querySelector('#posts');

  for (let i = 0; i < posts.length; i++) {

    let previousPosts = section.querySelectorAll('.overview-post');

    let pass = false;

    for(let previousPost of previousPosts){
      if(previousPost.querySelector('aside').getAttribute('data-id') === posts[i].id){
        pass = true;
        break;
      }
    }

    if(pass) continue;

    let post = document.createElement('article');
    post.classList.add('overview-post');
    post.innerHTML = '<aside class="voting_section" data-id="' + posts[i].id+ '">' +
    '<section class="vote upvote"></section>' + 
    '<h5 class="votes">' + posts[i].votes + '</h5>' + 
    '<section class="vote downvote"> </section></aside>'+
    '<header> <h3 class="username">' +
    '<img class="user-image" src="../images/users/default/user_icon.png" width="16" height="16"> ' + posts[i].username + '</h3>' +
    '<h3 class="creationDate">' + humanTiming(posts[i].creationDate) + '</h3> </header>' +
    '<h1 class="title">' + posts[i].title + '</h1>' +
    '<footer> <h5 class="comments"> <a href="post.php?id=' +posts[i].id+ '">' + posts[i].numComments + 
    ' Comment' + ( posts[i].comments == 1 ? '' :'s' )+ '</a> </h5> </footer>';

    checkUserImage(posts[i].author, post);
    checkPostImage(posts[i].id, post);
  
    section.appendChild(post);
  }

    let voteForms = document.querySelectorAll(".vote");
    voteForms.forEach((voteInstance)=>voteInstance.addEventListener('click',voteHandler));
}

function checkUserImage(id, post){
  var image = new Image();

  let element = post.querySelector('.user-image');

  image.onload = function() {
      // image exists and is loaded
      element.src = '../images/users/thumb_small/' + id + '.jpg';
  }
  image.onerror = function() {
      // image did not load
  }

  image.src ='../images/users/thumb_small/' + id + '.jpg';
}


function checkPostImage(id, post){

  var image = new Image();

  image.onload = function() {
      // image exists and is loaded
      let imageElement = document.createElement('img');
      imageElement.classList.add('post-image');
      imageElement.src = '../images/posts/thumb_medium/' + id + '.jpg';
      post.insertBefore(imageElement, post.querySelector('footer'));
  }
  image.onerror = function() {
      // image did not load
  }

  image.src ='../images/posts/thumb_medium/' + id + '.jpg';
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
  