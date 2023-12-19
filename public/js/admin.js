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

  let groupOwnerSetters = document.querySelectorAll('.group-owner');
    [].forEach.call(groupOwnerSetters, function(ownerSetter) {
        ownerSetter.addEventListener('click', sendGroupOwnerRequest);
    });

    let groupMemberSetters = document.querySelectorAll('.group-member');
    [].forEach.call(groupMemberSetters, function(memberSetter) {
        memberSetter.addEventListener('click', sendGroupMemberRequest);
    });

    let groupBannedSetters = document.querySelectorAll('.group-banned');
    [].forEach.call(groupBannedSetters, function(bannedSetter) {
        bannedSetter.addEventListener('click', sendGroupBannedRequest);
    });

    let groupAccepter = document.querySelectorAll('button.accept-group');
    [].forEach.call(groupAccepter, function(accepter) {
        accepter.addEventListener('click', acceptGroup);
    });

    let groupRejecter = document.querySelectorAll('button.reject-group');
    [].forEach.call(groupRejecter, function(rejecter) {
        rejecter.addEventListener('click', rejectGroup);
    });

    let userUnbanner = document.querySelectorAll('button.unban-user');
    [].forEach.call(userUnbanner, function(unbanner) {
        unbanner.addEventListener('click', unbanUser);
    });

    let appealRejecter = document.querySelectorAll('button.reject-appeal');
    [].forEach.call(appealRejecter, function(rejecter) {
        rejecter.addEventListener('click', rejectAppeal);
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

function sendGroupOwnerRequest() {
    let group_id = this.closest('.group-owner').getAttribute('group-id');
    let user_id = this.closest('.group-owner').getAttribute('user-id');
    sendAjaxRequest('post', '/api/admin/group/' + group_id + '/owner/' + user_id, null, groupOwnerHandler);
}

function groupOwnerHandler() {
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.group-owner[user-id="' + resp.owner.user_id + '"][group-id="' + resp.owner.group_id + '"]');
    let colors = document.querySelectorAll('.btn-'+resp.owner.group_id+'-'+resp.owner.user_id);
    if(resp.role == 'owner'){
        element.classList.remove('active');
        [].forEach.call(colors, function(color) {
            color.classList.remove('btn-info');
            color.classList.add('btn-secondary');
          });
    }
    else if(resp.role == 'member') {
        let oldElement = document.querySelector('.group-member[user-id="' + resp.owner.user_id + '"][group-id="' + resp.owner.group_id + '"]');
        oldElement.classList.remove('active');
        element.classList.add('active');
        [].forEach.call(colors, function(color) {
            color.classList.add('btn-info');
            color.classList.remove('btn-light');
          });
    }
    else if(resp.role == 'banned') {
        let oldElement = document.querySelector('.group-banned[user-id="' + resp.owner.user_id + '"][group-id="' + resp.owner.group_id + '"]');
        oldElement.classList.remove('active');
        element.classList.add('active');
        [].forEach.call(colors, function(color) {
            color.classList.add('btn-info')
            color.classList.remove('btn-dark');
          });
    }
    else if(resp.role == 'none') {
        element.classList.add('active');
        [].forEach.call(colors, function(color) {
            color.classList.add('btn-info');
            color.classList.remove('btn-secondary');
          });
    }
}

function sendGroupMemberRequest() {
    let group_id = this.closest('.group-member').getAttribute('group-id');
    let user_id = this.closest('.group-member').getAttribute('user-id');
    sendAjaxRequest('post', '/api/admin/group/' + group_id + '/member/' + user_id, null, groupMemberHandler);
}

function groupMemberHandler() {
    console.log(this.responseText);
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.group-member[user-id="' + resp.member.user_id + '"][group-id="' + resp.member.group_id + '"]');
    let colors = document.querySelectorAll('.btn-'+resp.member.group_id+'-'+resp.member.user_id);
    if(resp.role == 'member'){
        element.classList.remove('active');
        [].forEach.call(colors, function(color) {
            color.classList.remove('btn-light');
            color.classList.add('btn-secondary');
          });
    }
    else if(resp.role == 'owner') {
        let oldElement = document.querySelector('.group-owner[user-id="' + resp.member.user_id + '"][group-id="' + resp.member.group_id + '"]');
        oldElement.classList.remove('active');
        element.classList.add('active');
        [].forEach.call(colors, function(color) {
            color.classList.add('btn-light');
            color.classList.remove('btn-info');
          });
    }
    else if(resp.role == 'banned') {
        let oldElement = document.querySelector('.group-banned[user-id="' + resp.member.user_id + '"][group-id="' + resp.member.group_id + '"]');
        oldElement.classList.remove('active');
        element.classList.add('active');
        [].forEach.call(colors, function(color) {
            color.classList.add('btn-light');
            color.classList.remove('btn-dark');
          });
    }
    else if(resp.role == 'none') {
        element.classList.add('active');
        [].forEach.call(colors, function(color) {
            color.classList.add('btn-light');
            color.classList.remove('btn-secondary');
          });
    }
}

function sendGroupBannedRequest() {
    let group_id = this.closest('.group-banned').getAttribute('group-id');
    let user_id = this.closest('.group-banned').getAttribute('user-id');
    sendAjaxRequest('post', '/api/admin/group/' + group_id + '/banned/' + user_id, null, groupBannedHandler);
}

function groupBannedHandler() {
    console.log(this.responseText);
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('.group-banned[user-id="' + resp.banned.user_id + '"][group-id="' + resp.banned.group_id + '"]');
    let colors = document.querySelectorAll('.btn-'+resp.banned.group_id+'-'+resp.banned.user_id);
    if(resp.role == 'banned'){
        element.classList.remove('active');
        [].forEach.call(colors, function(color) {
            color.classList.remove('btn-dark');
            color.classList.add('btn-secondary');
          });

    }
    else if(resp.role == 'member') {
        let oldElement = document.querySelector('.group-member[user-id="' + resp.banned.user_id + '"][group-id="' + resp.banned.group_id + '"]');
        oldElement.classList.remove('active');
        element.classList.add('active');
        [].forEach.call(colors, function(color) {
            color.classList.add('btn-dark');
            color.classList.remove('btn-light');
          });
    }
    else if(resp.role == 'owner') {
        let oldElement = document.querySelector('.group-owner[user-id="' + resp.banned.user_id + '"][group-id="' + resp.banned.group_id + '"]');
        oldElement.classList.remove('active');
        element.classList.add('active');
        [].forEach.call(colors, function(color) {
            color.classList.add('btn-dark');
            color.classList.remove('btn-info');
          });
    }
    else if(resp.role == 'none') {
        element.classList.add('active');
        [].forEach.call(colors, function(color) {
            color.classList.add('btn-dark');
            color.classList.remove('btn-secondary');
          });
    }
}

function acceptGroup(){
    let group_id = this.closest('button.accept-group').getAttribute('data-id');
    console.log('accept'+group_id);
    sendAjaxRequest('post', '/api/admin/group/' + group_id + '/approval/', {decision: 'true'}, afterDecisionHandler);
}

function rejectGroup(){
    let group_id = this.closest('button.reject-group').getAttribute('data-id');
    sendAjaxRequest('post', '/api/admin/group/' + group_id + '/approval/', {decision: 'false'}, afterDecisionHandler);
}

function afterDecisionHandler(){
    console.log(this.responseText);
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('#country-' + resp.group.id);
    element.remove();
}

function unbanUser(){
    let appeal_id = this.closest('button.unban-user').getAttribute('data-id');
    sendAjaxRequest('post', '/api/admin/appeal/' + appeal_id + '/evaluate-appeal/', {decision: 'true'}, afterUnbanHandler);
}

function rejectAppeal(){
    let appeal_id = this.closest('button.reject-appeal').getAttribute('data-id');
    sendAjaxRequest('post', '/api/admin/appeal/' + appeal_id + '/evaluate-appeal/', {decision: 'false'}, afterUnbanHandler);
}

function afterUnbanHandler(){
    console.log(this.responseText);
    if (this.status != 200) window.location = '/';
    let resp = JSON.parse(this.responseText);
    let element = document.querySelector('#appeal-' + resp.appeal.id);
    let container = document.querySelector('.close-help');
    container.prepend(element);
    let cardFooter = element.querySelector('.card-footer');
    let acceptAppeal = resp.appeal.accept_appeal;

    if (acceptAppeal === true) {
        cardFooter.innerHTML = `
        Outcome: 
        <button type="button" class="btn btn-success reject-appeal" disabled>User Unbanned</button>
        `;
    } else if (acceptAppeal === false) {
        cardFooter.innerHTML = `
        Outcome: 
        <button type="button" class="btn btn-danger reject-appeal" disabled>Appeal Rejected</button>
        `;
    }
}



addEventListeners();