let voteForms = document.querySelectorAll(".vote");
voteForms.forEach((voteInstance)=>voteInstance.addEventListener('click',voteHandler));

function voteHandler(event){

    let vote=event.target;
    let upvote=(vote.classList.contains("upvote")?'true':'false');

    let entityID = event.path[2].getAttribute('data-id');
    
    let request = new XMLHttpRequest();
    request.addEventListener("load", function(){
      let info = JSON.parse(this.responseText);
      let aside = event.path[2];
      if(upvote==='true' && info['up']){
          vote.classList.add("upvote_triggered");
      }
      else if(upvote==='false' && info['up'] === 'false'){
          vote.classList.add("downvote_triggered")
      }else{
        aside.children[0].children[0].classList.remove("upvote_triggered")
        aside.children[2].children[0].classList.remove("downvote_triggered")
      }

      aside.children[1].innerHTML=info['votes'];
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
    let posts = document.querySelector('#posts');
  
    let lastPost = posts.querySelector('.overview-post:last-of-type');
  
    let lastCreationDate = lastPost.querySelector('.creationDate').textContent;
  
    console.log(lastCreationDate);
  
    let lastPostOffset = lastPost.offsetTop + lastPost.clientHeight;
  
    let pageOffset = window.pageYOffset + window.innerHeight;
  
    if (pageOffset > lastPostOffset - 20) {
      /*
          let request = new XMLHttpRequest();
          request.addEventListener('load', receivePost);
          request.open('post', '../actions/action_get_posts.php', true);
          request.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded') request.send(encodeForAjax(
              {parent_id: parent_id, text: text, comment_id: comment_id}));
  
       */
  
       console.log('scrolling');
  
  /* 
  
      var newDiv = document.createElement('div');
      newDiv.innerHTML = 'my awesome new div';
      document.getElementById('posts').appendChild(newDiv); */
    }
  };