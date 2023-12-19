
// Função para converter usernames em IDs e substituir menções por links
function convertUsernamesToLinks() {
    if (this.status === 200) {
        const resp = JSON.parse(this.responseText); // { 'username': user_id, ... }
        const userIds = resp.user_ids;
        const commentId = resp.commentId;

        const commentElement = document.getElementById(`comment-id-${commentId}`);
        const commentText = commentElement.textContent;

        // Substituir menções por links
        Object.keys(userIds).forEach(username => {
            const userId = userIds[username];
            const mentionRegex = new RegExp(`@`+username+`\\b`, 'g');
            const replacement = `<a href="/user/${userId}">@`+username+`</a>`;
            commentElement.innerHTML = commentElement.innerHTML.replace(mentionRegex, replacement);
        });

    } else {
        console.log(this.responseText);
        console.error('Erro na solicitação Ajax:', this.status);
    }
}


document.querySelectorAll('.post-comment').forEach(commentElement => {
    const idAttribute = commentElement.getAttribute('id');
    const commentId = idAttribute.match(/comment-id-(\d+)/);
    if (commentId) {
        sendAjaxRequest('get', '/api/comment/' + commentId[1] + '/Mentioned', null, convertUsernamesToLinks);
    }
});

