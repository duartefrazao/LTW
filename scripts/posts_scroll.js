document.addEventListener('scroll', function () {
    checkForNewPosts();
});

document.querySelector('.order').addEventListener('change', function (event) {
    changePostsOrder(this);
});


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
    }
];




function changePostsOrder(elem) {

    let order = elem.value;

    let offset = Number.MAX_SAFE_INTEGER;

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

    //DEFAULT
    let ordering = order + '-today';

    
    if( timeSpan !== null)
        ordering = order + '-' + timeSpan.value;


    document.querySelector('#posts').innerHTML = "";


    createRequest(receivePost, '../actions/action_get_posts.php', {
        offset: offset,
        criteria: ordering,
        name:pageWhereIam()
    });
}


function changeSpanValue(elem) {

    let order = document.querySelector('.order').value;

    let timeSpan = document.querySelector('.timeSpan').value;

    let ordering = order + "-" + timeSpan;

    let offset = Number.MAX_SAFE_INTEGER;


    document.querySelector('#posts').innerHTML = "";

    createRequest(receivePost, '../actions/action_get_posts.php', {
        offset: offset,
        criteria: ordering,
        name: pageWhereIam()
    });

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

        let post = document.createElement('article');
        post.classList.add('overview-post');
        let aside =document.createElement("aside");
        aside.setAttribute("class","voting_section");
        aside.setAttribute("data-id",posts[i].id);
        let section1 = document.createElement("section");
        if(response.id != null && posts[i].up == "true")
            section1.setAttribute("class","vote upvote upvote_triggered");
        else 
            section1.setAttribute("class","vote upvote");
        let h5 = document.createElement("h5");
        h5.setAttribute("class","votes")
        h5.innerText =  posts[i].votes;
        let section2 = document.createElement("section");
        if(response.id != null && posts[i].up == "false")
            section2.setAttribute("class","vote downvote downvote_triggered");
        else 
            section2.setAttribute("class","vote downvote");
        aside.appendChild(section1);
        aside.appendChild(h5);
        aside.appendChild(section2);
        let header = document.createElement("header");
        let h3 = document.createElement("h3");
        h3.setAttribute("class","username");
        let img = document.createElement("img");
        img.setAttribute("class","user-image");
        img.setAttribute("src","../images/users/default/user_icon.png");  
        img.setAttribute("width","16");
        img.setAttribute("height","16");
        h3.innerText=" "+posts[i].username;
        h3.insertBefore(img,h3.childNodes[0]);
        let h3_1 = document.createElement("h3");
        h3_1.setAttribute("class","creationDate");
        h3_1.innerText=humanTiming(posts[i].creationDate);
        header.appendChild(h3);
        header.appendChild(h3_1);
        let a = document.createElement("a");
        a.setAttribute("href","../pages/post.php?id="+posts[i].id);
        let h1 = document.createElement("h1");
        h1.setAttribute("class","title");
        h1.innerText=posts[i].title;
        a.appendChild(h1);
        let footer = document.createElement("footer");
        let h5_1 = document.createElement("h5");
        h5_1.setAttribute("class","comments");
        let a_1 = document.createElement("a");
        a_1.setAttribute("href","post.php?id="+ posts[i].id);
        a_1.innerText=posts[i].numComments + " Comment" + (posts[i].comments == 1 ? '' : 's');
        h5_1.appendChild(a_1);
        footer.appendChild(h5_1);
        post.appendChild(aside);
        post.appendChild(header);
        post.appendChild(a);
        post.appendChild(footer);

        checkUserImage(posts[i].author, post);
        checkPostImage(posts[i].id, post);

        section.appendChild(post);
    }

    let voteForms = document.querySelectorAll(".vote");
    voteForms.forEach((voteInstance) => voteInstance.addEventListener('click', voteHandler));
}

function getOffsetToOrder(lastPost) {

    let order = document.querySelector('.order').value;

    let spanTime = document.querySelector('.timeSpan') !== null ? document.querySelector('.timeSpan').value : null;

    let ordering = order + "-" + spanTime;

    let terms = ordering.split('-');

    let value = 0;

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

    return {
        offset: value,
        criteria: ordering,
        name:pageWhereIam()
    };

}



function checkUserImage(id, post) {
    var image = new Image();

    let element = post.querySelector('.user-image');

    image.onload = function () {
        // image exists and is loaded
        element.src = '../images/users/thumb_small/' + id + '.jpg';
    }
    image.onerror = function () {
        // image did not load
    }

    image.src = '../images/users/thumb_small/' + id + '.jpg';
}

function createRequest(handler, url, data) {
    let request = new XMLHttpRequest();
    request.addEventListener('load', handler);
    request.open('post', url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax(data));

    return request;
}



function checkPostImage(id, post) {

    var image = new Image();

    image.onload = function () {
        // image exists and is loaded
        let imageElement = document.createElement('img');
        imageElement.classList.add('post-image');
        imageElement.src = '../images/posts/thumb_medium/' + id + '.jpg';
        post.insertBefore(imageElement, post.querySelector('footer'));
    }
    image.onerror = function () {
        // image did not load
    }

    image.src = '../images/posts/thumb_medium/' + id + '.jpg';
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