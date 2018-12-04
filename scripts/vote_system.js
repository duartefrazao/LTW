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

  //================================SCROLL=============================================

document.addEventListener('scroll', function () {
    checkForNewPosts();
  });
  
  function checkForNewPosts() {
    let lastPost = posts.querySelector('#posts .overview-post:last-of-type');

    let lastPostId = lastPost.querySelector('aside').getAttribute('data-id');
  
    let lastPostOffset = lastPost.offsetTop + lastPost.clientHeight;
  
    let pageOffset = window.pageYOffset + window.innerHeight;
  
    if (pageOffset > lastPostOffset  + 10) {

      let request = new XMLHttpRequest();
      request.addEventListener('load', receivePost);
      request.open('post', '../actions/action_get_posts.php', true);
      request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
      request.send(encodeForAjax({lastId: lastPostId})) 
      
    }
  };

function receivePost(event){
  let posts = JSON.parse(this.responseText);
  let section = document.querySelector('#posts');

  for (let i = 0; i < posts.length; i++) {
    let post = document.createElement('article');
    post.classList.add('overview-post');
    post.innerHTML = '<aside class="voting_section" data-id="' + posts[i].id+ '">' +
    '<section class="vote upvote"></section>' + 
    '<h5 class="votes">' + posts[i].votes + '</h5>' + 
    '<section class="downvote"> </section></aside>'+
    '<header> <h3 class="username">' +
    '<i class="fas fa-user-circle"></i> ' + posts[i].username + '</h3>' +
    '<h3 class="creationDate">' + humanTiming(posts[i].creationDate) + '</h3> </header>' +
    '<h1 class="title">' + posts[i].title + '</h1>' +
    '<footer> <h5 class="comments"> <a href="post.php?id=' +posts[i].id+ '">' + posts[i].numComments + 
    ' Comment' + ( posts[i].comments == 1 ? '' :'s' )+ '</a> </h5> </footer>';
    section.appendChild(post);
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
