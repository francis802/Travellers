//post/comment highight the @mention

function highlightMentions(element_id, user_mentioned_id, username) {
    var postText = $('#' + element_id).text();

    postText = postText.replace(/@(\S+)/g, '<a href="/perfil/' + user_mentioned_id + '" class="perfil-link">@' + username + '</a>');

    $('#' + element_id).html(postText);
}