function addEventListeners() {
  let userAdminSetters = document.querySelectorAll('.admin-membership');
  [].forEach.call(userAdminSetters, function(adminSetter) {
    adminSetter.addEventListener('click', sendAdminMembershipRequest);
  });

  let userNormalSetters = document.querySelectorAll('.user-membership');
  [].forEach.call(userNormalSetters, function(userSetter) {
    userSetter.addEventListener('click', sendUserMembershipRequest);
  });

  let userBannedSetters = document.querySelectorAll('.banned-membership');
  [].forEach.call(userBannedSetters, function(bannedSetter) {
    bannedSetter.addEventListener('click', sendBannedMembershipRequest);
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

function sendAdminMembershipRequest() {
    let id = this.closest('.admin-membership').getAttribute('data-id');
    if (this.closest('.admin-membership.active') == null) {
    sendAjaxRequest('post', '/api/admin/membership/' + id + '/admin', null, adminMembershipHandler);
    }
}


function adminMembershipHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.admin-membership[data-id="' + resp.user.id + '"]');
    element.classList.add('active');
    if(resp.role == 'user') {
        let element = document.querySelector('.user-membership[data-id="' + resp.user.id + '"]');
        element.classList.remove('active');
    }
    if(resp.role == 'banned') {
        let element = document.querySelector('.banned-membership[data-id="' + resp.user.id + '"]');
        element.classList.remove('active');
    }
    let button = document.querySelector('.membership-btn-' + resp.user.id);
    button.textContent = 'Admin';
}

function sendUserMembershipRequest() {
    let id = this.closest('.user-membership').getAttribute('data-id');
    if (this.closest('.user-membership.active') == null) {
    sendAjaxRequest('post', '/api/admin/membership/' + id + '/user', null, userMembershipHandler);
    }
}


function userMembershipHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.user-membership[data-id="' + resp.user.id + '"]');
    element.classList.add('active');
    if(resp.role == 'admin') {
        let element = document.querySelector('.admin-membership[data-id="' + resp.user.id + '"]');
        element.classList.remove('active');
    }
    if(resp.role == 'banned') {
        let element = document.querySelector('.banned-membership[data-id="' + resp.user.id + '"]');
        element.classList.remove('active');
    }
    let button = document.querySelector('.membership-btn-' + resp.user.id);
    button.textContent = 'User';
}

function sendBannedMembershipRequest() {
    let id = this.closest('.banned-membership').getAttribute('data-id');
    if (this.closest('.banned-membership.active') == null) {
    sendAjaxRequest('post', '/api/admin/membership/' + id + '/banned', null, bannedMembershipHandler);
    }
}


function bannedMembershipHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.banned-membership[data-id="' + resp.user.id + '"]');
    element.classList.add('active');
    if(resp.role == 'user') {
        let element = document.querySelector('.user-membership[data-id="' + resp.user.id + '"]');
        element.classList.remove('active');
    }
    if(resp.role == 'admin') {
        let element = document.querySelector('.admin-membership[data-id="' + resp.user.id + '"]');
        element.classList.remove('active');
    }
    let button = document.querySelector('.membership-btn-' + resp.user.id);
    button.textContent = 'Banned';
}

addEventListeners();