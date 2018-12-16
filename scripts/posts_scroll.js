let page=null;
//retrieve the initial comments
window.onload = createRequest(receivePost, '../actions/action_get_posts.php', getOffsetToOrder(null));

document.addEventListener('scroll', function () {
    checkForNewPosts();
});

document.querySelector('.order').addEventListener('change', function (event) {
    changePostsOrder(this);
});

function addVoteListeners(element) {
    let votes = element.querySelectorAll('.vote');
    votes.forEach((vote) => vote.addEventListener('click', voteHandler));
  }
  




function checkForNewPosts() {
    let lastPost = posts.querySelector('#posts .overview-post:last-of-type');

    let lastPostOffset = lastPost.offsetTop + lastPost.clientHeight;

    let pageOffset = window.pageYOffset + window.innerHeight;

    if (pageOffset > lastPostOffset + 10) {
        createRequest(receivePost, '../actions/action_get_posts.php', getOffsetToOrder(lastPost));
    }
};

function receivePost(event) {
    let response = JSON.parse(this.responseText);
    let posts = response.data;

    let extensions = response.extension;
    let extensionsUsers = response.extensionUser;

    let section = document.querySelector('#posts');

    for (let i = 0; i < posts.length; i++) {

        let previousPosts = section.querySelectorAll('.overview-post');

        let pass = false;

        for (let previousPost of previousPosts) {
            if (previousPost.querySelector('aside').getAttribute('data-id') === posts[i].id) {
                pass = true;
                break;
            }
        }

        if (pass) continue;

        let post = createPost(posts[i], extensions[i], extensionsUsers[i]);

        section.appendChild(post);
    }
}

function getOffsetToOrder(lastPost) {

    let order = document.querySelector('.order').value;

    let spanTime = document.querySelector('.timeSpan') !== null ? document.querySelector('.timeSpan').value : null;

    let ordering = order + "-" + spanTime;

    let terms = ordering.split('-');

    let value = Number.MAX_SAFE_INTEGER;

    if (lastPost != null)
        switch (terms[0]) {

            case 'mostrecent':
                value = lastPost.querySelector('aside').getAttribute('data-id');
                break;
            case 'mostvoted':
                value = lastPost.querySelector('aside .votes').textContent;
                break;
            case 'mostcommented':
                value = lastPost.querySelector('.comments a').value;
                break;
        }

    let input = document.querySelector('#channel .info input[type="hidden"]');

    let channel_id = input != null ? input.value : null;    
    if(page==null){
        page = localStorage.page;
        localStorage.removeItem("page");
    }

    return {
        offset: value,
        criteria: ordering,
        name: pageWhereIam(),
        channel : channel_id,
        page:page
    };

}


function createPost(element, extension, extensionUser){

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


const spanTimes = [{
        text: 'Today',
        value: 'day'
    },
    {
        text: 'Last Week',
        value: 'week'
    },
    {
        text: 'Last Month',
        value: 'month'
    },
    {
        text: 'Last Year',
        value: 'year'
    },
    {
        text: 'All Time',
        value: 'all'
    }
];

/*----------------------------------------------------------*/
/*--------------------------POSTS ORDER---------------------*/
/*----------------------------------------------------------*/

function changePostsOrder(elem) {

    let timeSpan = document.querySelector('.timeSpan');

    if ((elem.value === 'mostvoted' || elem.value === 'mostcommented') && timeSpan === null) {

        let timeSpan = document.createElement('select');

        timeSpan.classList.add('timeSpan');

        spanTimes.forEach(span => {
            let option = document.createElement('option');
            option.text = span.text;
            option.value = span.value;

            timeSpan.add(option);
        });

        timeSpan.addEventListener('change', changeSpanValue);

        elem.parentNode.appendChild(timeSpan);

    } else if (elem.value == 'mostrecent') {

        if (!(elem.parentNode.childNodes[3] == null))
            elem.parentNode.removeChild(elem.parentNode.childNodes[3]);
    }

    document.querySelector('#posts').innerHTML = "";

    createRequest(receivePost, '../actions/action_get_posts.php', getOffsetToOrder(null));
}


function changeSpanValue(elem) {

    document.querySelector('#posts').innerHTML = "";

    createRequest(receivePost, '../actions/action_get_posts.php',getOffsetToOrder(null));

}


/*----------------------------------------------------------*/
/*--------------------------Utilities---------------------*/
/*----------------------------------------------------------*/


function checkUserImage(id, post, extension) {
    var image = new Image();

    let element = post.querySelector('.small-image');

    image.onload = function () {
        // image exists and is loaded
        element.setAttribute("width", "40");
        element.setAttribute("height", "40");
        if (extension == "gif")
            element.src = '../images/users/originals/' + id + '.' + extension;
        else
            element.src = '../images/users/thumb_medium/' + id + '.' + extension;

    }
    image.onerror = function () {
        // image did not load
    }

    if (extension == "gif")
        image.src = '../images/users/originals/' + id + '.' + extension;
    else
        image.src = '../images/users/thumb_medium/' + id + '.' + extension;
}

function createRequest(handler, url, data) {
    let request = new XMLHttpRequest();
    request.addEventListener('load', handler);
    request.open('post', url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax(data));

    return request;
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


function encodeForAjax(data) {
    return Object.keys(data)
        .map(function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
        })
        .join('&')
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

function pageWhereIam() {
    let url_string = window.location.href;
    let url = new URL(url_string);
    let name = url.searchParams.get("user");
    return name;
}