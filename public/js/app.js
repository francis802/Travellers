/*
function updateNotifications(){
  console.log('update notifications');
  
    fetch('/api/unseen-notifications')
      .then(response =>
        response.json()
        )
      .then(data => {
        const notificationCount = data;
  
                  const notificationSpan = document.querySelector('#notification-count');
  
                  if (notificationCount > 0) {
                      const newSpan = document.createElement('span');
                      newSpan.id = 'notification-count';
                      newSpan.textContent = notificationCount;
                      notificationSpan.parentNode.replaceChild(newSpan, notificationSpan);
                  } 
      })
      .catch(error => {
        console.error('Erro na requisição fetch:', error);
      });
  }
  
  updateNotifications();
  setInterval(updateNotifications, 5000); 
*/

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
    
    [].forEach.call(postButtonShower, function(postComment) {
      postComment.addEventListener('input', postButtonVisibility);
    });
  }

  let followUser = document.querySelectorAll('.request-follow');
  [].forEach.call(followUser, function(follow) {
  follow.addEventListener('click', sendFollowRequest);
  });

  let unfollowUser = document.querySelectorAll('.unfollow-user');
  [].forEach.call(unfollowUser, function(unfollow) {
  unfollow.addEventListener('click', sendUnfollowRequest);
  });

  let acceptUser = document.querySelectorAll('.accept-request');
  [].forEach.call(acceptUser, function(accept){
  accept.addEventListener('click', sendAcceptRequest);
  });

  let declineUser = document.querySelectorAll('.decline-request');
  [].forEach.call(declineUser, function(decline){
  decline.addEventListener('click', sendDeclineRequest);
  });

  let removeFollower = document.querySelectorAll('.remove-follower');
  [].forEach.call(removeFollower, function(remove){
    remove.addEventListener('click', sendRemoveFollowerRequest);
  });

  let joinGroup = document.querySelectorAll('.join-group');
  [].forEach.call(joinGroup, function(join) {
  join.addEventListener('click', joinGroupRequest);
  });

  let leaveGroup = document.querySelectorAll('.leave-group');
  [].forEach.call(leaveGroup, function(leave) {
  leave.addEventListener('click', leaveGroupRequest);
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
  }

  function createComment(comment, name) {
    let new_comment = document.createElement('li');
    new_comment.classList.add('post-comment');
    new_comment.id = 'comment-id-' + comment.id;
    let profile = location.protocol + '//' + location.host + '/user/' + comment.author_id;
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
    <div class="comment-body">
      <p class="comment-text">`+ comment.text + `</p>
      <button class="like-comment" data-id="` + comment.id + `">
        <h5 class="like-count">
          <i class="fa-regular fa-heart fa-1x" style="color: #cc0f0f;"></i>
        ` + 0 + `
        </h5>
      </button>
      <p class="comment-date">` + comment.date + `</p>
    </div>
    `;
  
    let creator = new_comment.querySelector('button.comment-edit');
    creator.addEventListener('click', clickEditComment);
  
    let deleter = new_comment.querySelector('button.comment-delete');
    deleter.addEventListener('click', sendDeleteCommentRequest);

    let liker = new_comment.querySelector('button.like-comment');
    liker.addEventListener('click', sendLikeCommentRequest);
  
    return new_comment;
  }

  function joinGroupRequest(event) {
    let id = this.closest('.join-group').getAttribute('data-id');
    sendAjaxRequest('put', '/api/group/' + id + '/join', null, joinRequestHandler);

    event.preventDefault();
  }

  function joinRequestHandler(event) {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.join-group[data-id="' + resp.group.id + '"]');

    element.removeEventListener('click', joinGroupRequest);
    element.className = 'leave-group';

    element.innerHTML = 'Leave'

    let new_members = document.querySelector('p.infos-with-margin.members a');
    let members = new_members.textContent;
    let new_members_count = parseInt(members) + 1;

    new_members.textContent = new_members_count + ' Members';

    element.addEventListener('click', leaveGroupRequest);
  }

  function leaveGroupRequest(event) {
    let id = this.closest('.leave-group').getAttribute('data-id');
    sendAjaxRequest('delete', '/api/group/' + id + '/leave', null, leaveRequestHandler);

    event.preventDefault();
  }

  function leaveRequestHandler(event) {
    if (this.status != 200) window.location = '/';
    console.log(this.responseText);
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.leave-group[data-id="' + resp.group.id + '"]');

    element.removeEventListener('click', leaveGroupRequest);
    element.className = 'join-group';

    element.innerHTML = 'Join'

    let new_members = document.querySelector('p.infos-with-margin.members a');
    let members = new_members.textContent;
    let new_members_count = parseInt(members) - 1;

    new_members.textContent = new_members_count + ' Members';

    element.addEventListener('click', joinGroupRequest);
  }

  

  function sendFollowRequest(event) {
    let id = this.closest('.request-follow').getAttribute('data-id');
    sendAjaxRequest('put', '/api/user/' + id + '/follow', null, followRequestHandler);

    event.preventDefault();
  }

  function followRequestHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.request-follow[data-id="' + resp.user.id + '"]');

    element.removeEventListener('click', sendFollowRequest);
    element.addEventListener('click', sendUnfollowRequest);

    element.className = 'unfollow-user';

    if (resp.user.profile_private) 
    element.innerHTML = 'Requested'
    else {
      element.innerHTML = 'Unfollow'  
      let new_count = document.querySelector('p.infos-with-margin.followers a');

      let followers = new_count.textContent;
      let new_followers = parseInt(followers) + 1;

      new_count.textContent = new_followers + ' Followers';
    }
  }

  function sendUnfollowRequest() {
    let id = this.closest('.unfollow-user').getAttribute('data-id');
    sendAjaxRequest('delete', '/api/user/' + id + '/unfollow', null, unfollowRequestHandler);
  }

  function unfollowRequestHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.unfollow-user[data-id="' + resp.user.id + '"]');

    element.removeEventListener('click', sendUnfollowRequest);
    element.addEventListener('click', sendFollowRequest);
    element.className = 'request-follow';

    element.innerHTML = 'Follow'

    if (!resp.user.profile_private) {
      let new_count = document.querySelector('p.infos-with-margin.followers a');

      let followers = new_count.textContent;
      let new_followers = parseInt(followers) - 1;

      new_count.textContent = new_followers + ' Followers';
    }
  }

  function sendAcceptRequest() {
    let id = this.closest('.accept-request').getAttribute('data-id');
    sendAjaxRequest('put', '/api/user/' + id + '/accept', null, acceptRequestHandler);
  }

  function acceptRequestHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('#follow-request-id-' + resp.user.id);

    element.style.display = 'none';
    element.remove();
  }

  function sendDeclineRequest() {
    let id = this.closest('.decline-request').getAttribute('data-id');
    sendAjaxRequest('delete', '/api/user/' + id + '/decline', null, declineRequestHandler);
  }

  function declineRequestHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('#follow-request-id-' + resp.user.id);

    element.style.display = 'none';
    element.remove();
  }

  function sendRemoveFollowerRequest() {
    let id = this.closest('.remove-follower').getAttribute('data-id');
    sendAjaxRequest('delete', '/api/user/' + id + '/remove', null, removeFollowerRequestHandler);
  }

  function removeFollowerRequestHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('#user-bar-id-' + resp.user.id);

    element.style.display = 'none';
    element.remove();

    let new_count = document.querySelector('h2');

    let new_followers = resp.followers - 1;

    new_count.textContent = 'Followers (' + new_followers + ')';
  }



  function removeMemberRequest(button) {
    // Obtém o elemento li correspondente ao botão clicado
    let liElement = button.closest('li');

    // Verifica se encontrou o elemento li
    if (liElement) {
        let group_id = liElement.getAttribute('data-id');
        let user_id = liElement.getAttribute('data-user-id'); // Adicione este atributo ao seu <li>

        console.log(group_id);
        console.log(user_id);
        
        sendAjaxRequest('delete', '/api/group/' + group_id +'/remove/' + user_id, null, removeMemberRequestHandler);
    } else {
        console.error('Elemento li não encontrado.');
    }
  }

  function removeMemberRequestHandler() {
    if (this.status === 200) {
      
      const resp = JSON.parse(this.responseText);

      const userId = resp.user_id;

      console.log(userId);

      const liToRemove = document.querySelector(`li[data-user-id="${userId}"]`);
      if (liToRemove) {
          liToRemove.remove();
      } else {
          console.error('Elemento <li> não encontrado para remoção.');
      }
  } else {
      console.error('Erro na solicitação Ajax:', this.status);
  }
  }

  function upgradeToOwnerRequest(button) {
    // Obtém o elemento li correspondente ao botão clicado
    let liElement = button.closest('li');

    // Verifica se encontrou o elemento li
    if (liElement) {
        let group_id = liElement.getAttribute('data-id');
        let user_id = liElement.getAttribute('data-user-id'); // Adicione este atributo ao seu <li>

        console.log(group_id);
        console.log(user_id);
        
        sendAjaxRequest('delete', '/api/group/' + group_id +'/upgrade/' + user_id, null, upgradeToOwnerRequestHandler);
    } else {
        console.error('Elemento li não encontrado.');
    }
  }

  function upgradeToOwnerRequestHandler() {
    if (this.status === 200) {
      
      const resp = JSON.parse(this.responseText);

      const userId = resp.user_id;

      console.log(userId);

      const buttonRemove = document.querySelector(`li[data-user-id="${userId}"] .upgrade-member`);
      if (buttonRemove) {
        buttonRemove.remove();
      } else {
          console.error('Elemento <button> não encontrado para remoção.');
      }
  } else {
      console.error('Erro na solicitação Ajax:', this.status);
  }
  }



addEventListeners();