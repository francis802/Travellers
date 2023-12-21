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

  function recoverPassword() {
    const email = document.querySelector("#recoverEmail").value;
    if (email == "") {
      alert("Empty email. Please try again.")
      return;
    }
    document.querySelector("#recoverAttemp").value = email;
    sendAjaxRequest('post', '/sendEmail', {email: email});
    document.querySelector("#recover").hidden = true;
    document.querySelector("#recoverPassword").hidden = false;
  }


addEventListeners();