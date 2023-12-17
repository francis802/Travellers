function changeBlockStatus(event) {
    event.preventDefault();

    const link = event.target;

    const isBlocked = link.classList.contains('blocked');

    if (isBlocked) {
        unblockUser(link);
    } else {
        blockUser(link);
    }
}

function blockUser(link) {
    let user_id = link.getAttribute('data-user-id');
    console.log('Tentativa de bloqueio de:', user_id);
    sendAjaxRequest('put', '/api/user/block/' + user_id, null, blockUserHandler);
}

function blockUserHandler(){
    if (this.status === 200) {
      
        const resp = JSON.parse(this.responseText);
        const userId = resp.user_id;

        console.log('Bloqueio com sucesso de:', userId);
        console.log(this.responseText);

        const link_to_chane = document.querySelector(`a[data-user-id="${userId}"]`);
        link_to_chane.classList.add('blocked');
        link_to_chane.textContent = 'Unblock';
    } 
    else {
        console.error('Erro na solicitação Ajax:', this.status);
    }
}

function unblockUser(link){
    let user_id = link.getAttribute('data-user-id');
    console.log('Tentativa de desbloqueio de:', user_id);
    sendAjaxRequest('delete', '/api/user/unblock/' + user_id, null, unblockUserHandler);
}


function unblockUserHandler(){
    if (this.status === 200) {
      
        const resp = JSON.parse(this.responseText);
        const userId = resp.user_id;
        console.log('Desbloqueio com sucesso de:', userId);

        const link_to_chane = document.querySelector(`a[data-user-id="${userId}"]`);
        link_to_chane.classList.remove('blocked');
        link_to_chane.textContent = 'Block';
    } 
    else {
        console.error('Erro na solicitação Ajax:', this.status);
    }
}