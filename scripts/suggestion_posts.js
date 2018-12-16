window.onload = createRequest(receivePost, '../actions/action_get_search_posts.php', {
    'search': findGetParameter('search')
});

function receivePost() {

    let response = JSON.parse(this.responseText);

    let posts = response.data;

    if(posts.length === 0)
        return; 

    let extensions = response.extension;
    let extensionsUsers = response.extensionUser;
    
    let section = document.querySelector('#posts');

    for (let i = 0; i < posts.length; i++) {

        let post = createPost(posts[i], extensions[i], extensionsUsers[i]);

        section.appendChild(post);
    }

}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function checkUserImage(id, comment, extension) {

    var image = new Image();

    let element = comment.querySelector('.small-image');

    image.onload = function () {
        // image exists and is loaded

        if (extension == "gif") {
            element.src = '../images/users/originals/' + id + '.' + extension;
            element.width = 28;
            element.height = 28;
            element.setAttribute("class", "gif_small");
        } else
            element.src = '../images/users/thumb_small/' + id + '.' + extension;
    }
    image.onerror = function () {
        // image did not load
        console.warn('on error:', comment.querySelector('img'));
    }

    if (extension == "gif") {
        image.src = '../images/users/originals/' + id + '.' + extension;
        image.width = 28;
        image.height = 28;
        image.setAttribute("class", "gif_small");
    } else
        image.src = '../images/users/thumb_medium/' + id + '.' + extension;
}




function checkPostImage(id, post, extension) {

    var image = new Image();

    image.onload = function () {
        // image exists and is loaded
        let imageElement = document.createElement('img');
        imageElement.classList.add('post-image');

        if (extension == "gif")
            imageElement.src = '../images/posts/originals/' + id + '.' + extension;
        else
            imageElement.src = '../images/posts/thumb_medium/' + id + '.' + extension;
        post.insertBefore(imageElement, post.querySelector('footer'));
    }
    image.onerror = function () {
        // image did not load
    }

    if (extension == "gif")
        image.src = '../images/posts/originals/' + id + '.' + extension;
    else
        image.src = '../images/posts/thumb_medium/' + id + '.' + extension;
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


function createRequest(handler, url, data) {
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


function createPost(element, extension, extensionUser) {

    let post = document.createElement('article');
    post.classList.add('overview-post');

    post.innerHTML =
        '<aside class="voting_section" data-id="' + element.id + '">' +
        '<section class="vote upvote ' + (element.up === "true" ? 'upvote_triggered' : '') + '"></section>' +
        '<h5 class="votes">' + element.votes + '</h5>' +
        '<section class="vote downvote ' + (element.up === "false" ? 'downvote_triggered' : '') + '"> </section></aside>' +
        '<header> <h3 class="author">' + element.author + '</h3>' +
        '<a class="user-info" href="../pages/profile.php?user=' + element.username + '">' +
        '<div> <img class="small-image" src="../images/users/default/default.png"></div>' +
        '<h3>' + element.username + '</h3> </a>' +
        '<a class="channel-link" href="../pages/channel.php?channel=' + element.channel + '">' + element.channelTitle + '</a>' +
        '<h3 class="creationDate">' + humanTiming(element.creationDate) + '</h3> </header>' +
        '<a href="../pages/post.php?id=' + element.id + '">' +
        '<h1 class="title">' + element.title + '</h1> </a>' +
        '<footer> <h5 class="comments"> <a href="post.php?id=' + element.id + '">' + element.numComments +
        ' Comment' + (element.comments == 1 ? '' : 's') + '</a> </h5> </footer>';


    if (extensionUser != null)
        checkUserImage(element.author, post, extensionUser);
    if (extension != null)
        checkPostImage(element.id, post, extension);

    addVoteListeners(post);

    return post;

}


function addVoteListeners(element) {
    let votes = element.querySelectorAll('.vote');
    votes.forEach((vote) => vote.addEventListener('click', voteHandler));
}
  

