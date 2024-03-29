function addEventListeners() {
    let itemDeleters = document.querySelectorAll('.post-delete');
    [].forEach.call(itemDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeletePostRequest);
    });
  
    let likePost = document.querySelectorAll('.like-post');
    [].forEach.call(likePost, function(like) {
      like.addEventListener('click', sendLikePostRequest);
    });
  
    let dislikePost = document.querySelectorAll('.dislike-post');
    [].forEach.call(dislikePost, function(dislike) {
      dislike.addEventListener('click', sendDislikePostRequest);
    });
  
    let likeComment = document.querySelectorAll('.like-comment');
    [].forEach.call(likeComment, function(like) {
      like.addEventListener('click', sendLikeCommentRequest);
    });
  
    let dislikeComment = document.querySelectorAll('.dislike-comment');
    [].forEach.call(dislikeComment, function(dislike) {
      dislike.addEventListener('click', sendDislikeCommentRequest);
    });
  
    let commentDeleter = document.querySelectorAll('.comment-delete');
    [].forEach.call(commentDeleter, function(deleter) {
      deleter.addEventListener('click', sendDeleteCommentRequest);
    });
  
    let commentEditor = document.querySelectorAll('.comment-edit');
    [].forEach.call(commentEditor, function(editor) {
      editor.addEventListener('click', clickEditComment);
    });
  
    let commentCreator = document.querySelectorAll('.comment-create');
    [].forEach.call(commentCreator, function(creator) {
      creator.addEventListener('click', sendCreateCommentRequest);
    });
  
    let postComment = document.querySelector('textarea#comment');
    if (postComment != null) {
      postComment.addEventListener('input', postButtonVisibility);
    }

    let postSharer = document.querySelectorAll('.post-share');
    [].forEach.call(postSharer, function(share) {
      share.addEventListener('click', sendSharePostRequest);
    });
}

  
function postButtonVisibility() {
    let postButton = document.querySelector('button.comment-create');
    if (this.value.length > 0) {
      postButton.style.display = 'inline-block';
    } else {
      postButton.style.display = 'none';
    }
  }
  
  function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }
  
  function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();
  
    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
  }
  
  function sendDeletePostRequest() {
    let id = this.closest('.post-delete').getAttribute('data-id');
    sendAjaxRequest('delete', '/api/post/' + id + '/delete', null, postDeletedHandler);
  }

  
  function postDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let post = JSON.parse(this.responseText);
    let element = document.querySelector('#post-id-' + post.id );
    element.style.display = 'none';
    element.remove();
    var modal = document.getElementById('delete-post-popup-' + post.id);

    if (modal) {
    modal.classList.remove('show');

    document.body.classList.remove('modal-open');

    var modalBackdrop = document.querySelector('.modal-backdrop');
    if (modalBackdrop) {
        modalBackdrop.remove();
    }

    // Remove inline styles from body
    document.body.removeAttribute('style');

    // Remove the modal from the DOM
    modal.parentNode.removeChild(modal);
    }
  }

  function sendCreateCommentRequest(event) {
    let text = document.querySelector('textarea#comment').value;
    let id = this.closest('.comment-create').getAttribute('post-id');
    if (text != '')
      sendAjaxRequest('put', '/api/comment/create', {text: text, post_id: id}, commentCreatedHandler);

    event.preventDefault();
  }

  
  function commentCreatedHandler() {
    if (this.status != 200) window.location = '/';
    let comment_obj = JSON.parse(this.responseText);
    let comment = createComment(comment_obj.comment, comment_obj.author);
    var comment_section = document.querySelector("ul.post-comments-list");
    if (comment_section.firstChild) {
      comment_section.insertBefore(comment, comment_section.firstChild);
    } else {
      comment_section.appendChild(comment);
    }
    document.querySelector('textarea#comment').value = '';
    document.querySelector('button.comment-create').style.display = 'none';
    let num_comments = document.querySelector('h5.comment-count').textContent
    let num = parseInt(num_comments) + 1;
    document.querySelector('h5.comment-count').innerHTML = `<i class="fa-regular fa-comment fa-2x"></i>` + num;
  }

  function sendLikePostRequest() {
    let id = this.closest('.like-post').getAttribute('data-id');
    sendAjaxRequest('post', '/api/post/' + id + '/like', null, postLikedHandler);
  }

  function postLikedHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.like-post[data-id="' + resp.post.id + '"]');
    
    element.removeEventListener('click', sendLikePostRequest);
    element.addEventListener('click', sendDislikePostRequest);
    element.className = 'dislike-post';

    element.innerHTML = '<h5 class="like-count">' +
    '<i class="fa-solid fa-heart fa-2x" style="color: #cc0f0f;"></i>' +
    resp.likes +
    '</h5>'
  }

  function sendDislikePostRequest() {
    let id = this.closest('.dislike-post').getAttribute('data-id');
    sendAjaxRequest('delete', '/api/post/' + id + '/dislike', null, postDislikedHandler);
  }

  function postDislikedHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.dislike-post[data-id="' + resp.post.id + '"]');

    element.removeEventListener('click', sendDislikePostRequest);
    element.addEventListener('click', sendLikePostRequest);
    element.className = 'like-post';

    element.innerHTML = '<h5 class="like-count">' +
    '<i class="fa-regular fa-heart fa-2x" style="color: #cc0f0f;"></i>' +
    resp.likes +
    '</h5>'
  }

  function sendDeleteCommentRequest() {
    let id = this.closest('.comment-delete').getAttribute('data-id');
    sendAjaxRequest('delete', '/api/comment/' + id + '/delete', null, commentDeletedHandler);
  }

  function sendLikeCommentRequest() {
    let id = this.closest('.like-comment').getAttribute('data-id');
    sendAjaxRequest('post', '/api/comment/' + id + '/like', null, commentLikedHandler);
  }

  function commentLikedHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.like-comment[data-id="' + resp.comment.id + '"]');
    
    element.removeEventListener('click', sendLikeCommentRequest);
    element.addEventListener('click', sendDislikeCommentRequest);
    element.className = 'dislike-comment';

    element.innerHTML = '<h5 class="like-count">' +
    '<i class="fa-solid fa-heart fa-1x" style="color: #cc0f0f;"></i>' +
    resp.likes +
    '</h5>'
  }

  function sendDislikeCommentRequest() {
    let id = this.closest('.dislike-comment').getAttribute('data-id');
    sendAjaxRequest('delete', '/api/comment/' + id + '/dislike', null, commentDislikedHandler);
  }

  function commentDislikedHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.dislike-comment[data-id="' + resp.comment.id + '"]');

    element.removeEventListener('click', sendDislikeCommentRequest);
    element.addEventListener('click', sendLikeCommentRequest);
    element.className = 'like-comment';

    element.innerHTML = '<h5 class="like-count">' +
    '<i class="fa-regular fa-heart fa-1x" style="color: #cc0f0f;"></i>' +
    resp.likes +
    '</h5>'
  }

  function sendDeleteCommentRequest() {
    let id = this.closest('.comment-delete').getAttribute('data-id');
    sendAjaxRequest('delete', '/api/comment/' + id + '/delete', null, commentDeletedHandler);
  }

  
  function commentDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let comment = JSON.parse(this.responseText);
    let element = document.querySelector('#comment-id-' + comment.id );
    element.style.display = 'none';
    element.remove();
    let num_comments = document.querySelector('h5.comment-count').textContent
    let num = parseInt(num_comments) - 1;
    document.querySelector('h5.comment-count').innerHTML = `<i class="fa-regular fa-comment fa-2x"></i>` + num;
  }

  function clickEditComment() {
    let id = this.closest('.comment-edit').getAttribute('data-id');
    let comment = document.querySelector('#comment-id-' + id);
    let comment_text_ele = comment.querySelector('.comment-text');
    let comment_text = comment_text_ele.innerHTML;
    const commentTextWithoutAnchors = comment_text.replace(/<a\b[^>]*>(.*?)<\/a>/g, '$1');
    comment.querySelector('.comment-edit').style.display = 'none';
    comment.querySelector('.comment-delete').style.display = 'none';
    if(comment.querySelector('.comment-edited') != null)
      comment.querySelector('.comment-edited').style.display = 'none';
    comment.querySelector('.comment-date').style.display = 'none';
    comment_text_ele.style.display = 'none';
    if(comment.querySelector('.like-comment') != null){
      comment.querySelector('.like-comment').style.display = 'none';
    }
    else{
      comment.querySelector('.dislike-comment').style.display = 'none';
    }
    comment.innerHTML += '<textarea class="comment-text-area">' + commentTextWithoutAnchors + '</textarea>'
      + '<button class="comment-cancel" data-id="' + id + '"> <i class="fa-regular fa-circle-xmark"></i> </button>'
      + '<button class="comment-send" data-id="' + id + '"> <i class="fa-regular fa-circle-check"></i> </button>';
    comment.querySelector('.comment-send').addEventListener('click', sendEditCommentRequest);
    comment.querySelector('.comment-cancel').addEventListener('click', function() {
      cancelEditComment.call(this, commentTextWithoutAnchors);
    });
  }

  function cancelEditComment(comment_text) {
    let id = this.closest('.comment-cancel').getAttribute('data-id');
    let comment = document.querySelector('#comment-id-' + id);
    comment.querySelector('.comment-text').textContent = comment_text;
    comment.querySelector('.comment-text').style.display = 'block';
    restoreEditComment(comment);
  }

  function sendEditCommentRequest() {
    let id = this.closest('.comment-send').getAttribute('data-id');
    let comment = document.querySelector('#comment-id-' + id);
    let comment_text = comment.querySelector('.comment-text-area').value;
    sendAjaxRequest('post', '/api/comment/' + id + '/edit', {text: comment_text}, commentEditHandler);
  }

  
  function commentEditHandler() {
    console.log(this.responseText);
    if (this.status != 200) window.location = '/';
    let comment_obj = JSON.parse(this.responseText);
    let comment = document.querySelector('#comment-id-' + comment_obj.id);
    comment.querySelector('.comment-text').textContent = comment_obj.text;
    comment.querySelector('.comment-text').style.display = 'block';
    restoreEditComment(comment);
  }

  function restoreEditComment(comment) {
    comment.querySelector('.comment-text-area').remove();
    comment.querySelector('.comment-send').remove();
    comment.querySelector('.comment-cancel').remove();
    comment.querySelector('.comment-edit').style.display = 'inline-block';
    comment.querySelector('.comment-delete').style.display = 'inline-block';
    if(comment.querySelector('.comment-edited') != null)
      comment.querySelector('.comment-edited').style.display = 'block';
    comment.querySelector('.comment-date').style.display = 'block';
    comment.querySelector('.comment-delete').addEventListener('click', sendDeleteCommentRequest);
    comment.querySelector('.comment-edit').addEventListener('click', clickEditComment);
    if(comment.querySelector('.like-comment') != null){
      comment.querySelector('.like-comment').style.display = 'inline-block';
      comment.querySelector('.like-comment').addEventListener('click', sendLikeCommentRequest);
    }
    else{
      comment.querySelector('.dislike-comment').style.display = 'inline-block';
      comment.querySelector('.dislike-comment').addEventListener('click', sendDislikeCommentRequest);
    }
    const idAttribute = comment.getAttribute('id');
    const commentId = idAttribute.match(/comment-id-(\d+)/);
    if (commentId) {
        sendAjaxRequest('get', '/api/comment/' + commentId[1] + '/mentioned', null, convertUsernamesToLinks);
    }
  }

  function createComment(comment, name) {
    let new_comment = document.createElement('li');
    new_comment.classList.add('post-comment');
    new_comment.classList.add('list-group-item');
    new_comment.id = 'comment-id-' + comment.id;
    let profile = location.protocol + '//' + location.host + '/user/' + comment.author_id;
    new_comment.innerHTML = `
    <div class="post-comment-author">
        <a href="`+ profile + `" class="post-comment-author-name">
            `+ name + `
        </a>
    </div>
    <div class="post-comment-edit-delete">
            <button class="comment-edit" data-id="` + comment.id + `">
                <i class="fa-solid fa-pen fa-1x"></i>
            </button>
            <button class="comment-delete" data-id="` + comment.id + `">
                <i class="fa-solid fa-trash fa-1x"></i>
            </button>
    </div>
    <div class="comment-body">
      <p class="comment-text">`+ comment.text + `</p>
      <button class="like-comment" data-id="` + comment.id + `">
        <h5 class="like-count">
          <i class="fa-regular fa-heart fa-1x" style="color: #cc0f0f;"></i>
        ` + 0 + `
        </h5>
      </button>
      <div class="comment-date">
      <p class="comment-date">` + comment.date + `</p>
      </div>
    </div>
    `;
  
    let creator = new_comment.querySelector('button.comment-edit');
    creator.addEventListener('click', clickEditComment);
  
    let deleter = new_comment.querySelector('button.comment-delete');
    deleter.addEventListener('click', sendDeleteCommentRequest);

    let liker = new_comment.querySelector('button.like-comment');
    liker.addEventListener('click', sendLikeCommentRequest);

    sendAjaxRequest('get', '/api/comment/' + comment.id + '/mentioned', null, convertUsernamesToLinks);
  
    return new_comment;
  }


// Função para converter usernames em IDs e substituir menções por links
function convertUsernamesToLinks() {
    if (this.status === 200) {
        const resp = JSON.parse(this.responseText); // { 'username': user_id, ... }
        const userIds = resp.user_ids;
        const commentId = resp.commentId;

        const commentElement = document.getElementById(`comment-id-`+commentId);
        const commentText = commentElement.textContent;

        // Substituir menções por links
        Object.keys(userIds).forEach(username => {
            const userId = userIds[username];
            const mentionRegex = new RegExp(`@`+username+`\\b`, 'g');
            const replacement = `<a class="mentioned-user" href="/user/`+ userId +`">@`+username+`</a>`;
            commentElement.innerHTML = commentElement.innerHTML.replace(mentionRegex, replacement);
        });

        let creator = commentElement.querySelector('button.comment-edit');
        if(creator != null)
        creator.addEventListener('click', clickEditComment);
    
        let deleter = commentElement.querySelector('button.comment-delete');
        if(deleter != null)
        deleter.addEventListener('click', sendDeleteCommentRequest);

        let liker = commentElement.querySelector('button.like-comment');
        if(liker != null){
            liker.addEventListener('click', sendLikeCommentRequest);
        }
        else {
            liker = commentElement.querySelector('button.dislike-comment');
            liker.addEventListener('click', sendDislikeCommentRequest);
        }

    } else {
        console.log(this.responseText);
        console.error('Erro na solicitação Ajax:', this.status);
    }
}

function parseMentions(){
    document.querySelectorAll('.post-comment').forEach(commentElement => {
        const idAttribute = commentElement.getAttribute('id');
        const commentId = idAttribute.match(/comment-id-(\d+)/);
        if (commentId) {
            sendAjaxRequest('get', '/api/comment/' + commentId[1] + '/mentioned', null, convertUsernamesToLinks);
        }
    });
}

function parsePostMentions(){
  document.querySelectorAll('.post-view').forEach(commentElement => {
      const idAttribute = commentElement.getAttribute('id');
      const postId = idAttribute.match(/post-id-(\d+)/);
      if (postId) {
          sendAjaxRequest('get', '/api/post/' + postId[1] + '/mentioned', null, postMentionsToLinks);
      }
  });
}

function postMentionsToLinks() {
  if (this.status === 200) {
      const resp = JSON.parse(this.responseText); // { 'username': user_id, ... }
      const userIds = resp.user_ids;
      const postId = resp.postId;

      const postElement = document.getElementById(`post-id-` + postId);
      const postDescription = postElement.querySelector('.post-description');

      // Substituir menções por links
      Object.keys(userIds).forEach(username => {
          const userId = userIds[username];
          const mentionRegex = new RegExp(`@`+username+`\\b`, 'g');
          const replacement = `<a class="mentioned-user" href="/user/`+ userId +`">@`+username+`</a>`;
          postDescription.innerHTML = postDescription.innerHTML.replace(mentionRegex, replacement);
      });


  } else {
      console.log(this.responseText);
      console.error('Erro na solicitação Ajax:', this.status);
  }
}

function sendSharePostRequest(event) {
  let post_id = this.closest('.post-share').getAttribute('post-id');
  let user_id = this.closest('.post-share').getAttribute('user-id');
  let post_url = location.protocol + '//' + location.host + '/post/' + post_id;
  sendAjaxRequest('put', '/api/post/share/user/' + user_id , {post_url: post_url}, postSharedHandler);

  event.preventDefault();
}

function postSharedHandler() {
  console.log(this.responseText);
  if (this.status != 200) window.location = '/';
  let resp = JSON.parse(this.responseText);
  if(resp.success){
    var alertDiv = document.createElement('div');
    
    alertDiv.classList.add('alert', 'alert-success');
    alertDiv.setAttribute('role', 'alert');
    alertDiv.setAttribute('id', 'success-alert');
    
    alertDiv.textContent = 'Post Shared Successfully!';

    document.body.appendChild(alertDiv);
  }
}

parsePostMentions();

parseMentions();

addEventListeners();