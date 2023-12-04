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
  postComment.addEventListener('input', postButtonVisibility);
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
  }

  function sendCreateCommentRequest() {
    let text = document.querySelector('textarea#comment').value;
    let id = this.closest('.comment-create').getAttribute('post-id');
    if (text != '')
      sendAjaxRequest('put', '/api/comment/create', {text: text, post_id: id}, commentCreatedHandler);
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
    '<i class="fa-solid fa-heart fa-3x" style="color: #cc0f0f;"></i>' +
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
    '<i class="fa-regular fa-heart fa-3x" style="color: #cc0f0f;"></i>' +
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
  }

  function clickEditComment() {
    let id = this.closest('.comment-edit').getAttribute('data-id');
    let comment = document.querySelector('#comment-id-' + id);
    let comment_text_ele = comment.querySelector('.comment-text');
    let comment_text = comment_text_ele.innerHTML;
    comment.querySelector('.comment-edit').style.display = 'none';
    comment.querySelector('.comment-delete').style.display = 'none';
    comment_text_ele.remove();
    comment.innerHTML += '<textarea class="comment-text-area">' + comment_text + '</textarea>'
      + '<button class="comment-cancel" data-id="' + id + '"> <i class="fa-regular fa-circle-xmark"></i> </button>'
      + '<button class="comment-send" data-id="' + id + '"> <i class="fa-regular fa-circle-check"></i> </button>';
    comment.querySelector('.comment-send').addEventListener('click', sendEditCommentRequest);
    comment.querySelector('.comment-cancel').addEventListener('click', function() {
      cancelEditComment.call(this, comment_text);
    });
  }

  function cancelEditComment(comment_text) {
    let id = this.closest('.comment-cancel').getAttribute('data-id');
    let comment = document.querySelector('#comment-id-' + id);
    comment.innerHTML += '<p class="comment-text">' + comment_text + '</p>';
    restoreEditComment(comment);
  }

  function sendEditCommentRequest() {
    let id = this.closest('.comment-send').getAttribute('data-id');
    let comment = document.querySelector('#comment-id-' + id);
    let comment_text = comment.querySelector('.comment-text-area').value;
    sendAjaxRequest('post', '/api/comment/' + id + '/edit', {text: comment_text}, commentEditHandler);
  }

  
  function commentEditHandler() {
    if (this.status != 200) window.location = '/';
    let comment_obj = JSON.parse(this.responseText);
    let comment = document.querySelector('#comment-id-' + comment_obj.id);
    comment.innerHTML += '<p class="comment-text">' + comment_obj.text + '</p>';
    restoreEditComment(comment);
  }

  function restoreEditComment(comment) {
    comment.querySelector('.comment-text-area').remove();
    comment.querySelector('.comment-send').remove();
    comment.querySelector('.comment-cancel').remove();
    comment.querySelector('.comment-edit').style.display = 'inline-block';
    comment.querySelector('.comment-delete').style.display = 'inline-block';
    comment.querySelector('.comment-delete').addEventListener('click', sendDeleteCommentRequest);
    comment.querySelector('.comment-edit').addEventListener('click', clickEditComment);
  }

  function createComment(comment, name) {
    let new_comment = document.createElement('li');
    new_comment.classList.add('post-comment');
    new_comment.id = 'comment-id-' + comment.id;
    let profile = location.hostname + '/user/' + comment.author_id;
    console.log(profile);
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
    <p class="comment-text">`+ comment.text + `</p>
    `;
  
    let creator = new_comment.querySelector('button.comment-edit');
    creator.addEventListener('click', clickEditComment);
  
    let deleter = new_comment.querySelector('button.comment-delete');
    deleter.addEventListener('click', sendDeleteCommentRequest);
  
    return new_comment;
  }


addEventListeners();