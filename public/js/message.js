function addEventListeners() {

let messageSender = document.querySelectorAll('.send-msg');
    [].forEach.call(messageSender, function(sender) {
      sender.addEventListener('click', sendMessage);
    });

}

function sendMessage(event) {
    let text = document.querySelector('textarea#message').value;
    let id = this.closest('.send-msg').getAttribute('to-user');
    if (text != '')
      sendAjaxRequest('put', '/api/message/send', {text: text, user_id: id}, sendMessageHandler);

    event.preventDefault();
}

  
function sendMessageHandler() {
    if (this.status != 200) window.location = '/';
    let message_obj = JSON.parse(this.responseText);
    let message = createMyMessage(message_obj.message);
    var message_section = document.querySelector("section.message-view");
    if (message_section.lastChild) {
        message_section.insertBefore(message, message_section.lastChild);
    } else {
        message_section.appendChild(message);
    }
    document.querySelector('textarea#message').value = '';
    scrollToBottom();
}

function createMyMessage(message) {
    let new_message = document.createElement('div');
    new_message.classList.add('card');
    new_message.classList.add('my-msg');
    new_message.innerHTML = `<div class="card-body">` + message.content +`</div>`;
    return new_message;
}

function createOtherMessage(message) {
  let new_message = document.createElement('div');
  new_message.classList.add('card');
  new_message.classList.add('other-msg');
  new_message.innerHTML = `<div class="card-body">` + message.content +`</div>`;
  return new_message;
}

function updateMessages() {
  const messageView = document.querySelector('section.message-view');
  if (!messageView) return;
  const userId = messageView.getAttribute('logged-user');
  const senderId = messageView.getAttribute('other-user');
  if (!userId) return;
  const pusherAppKey = "c3503c276e27ad2b1bab";
  const pusherCluster = "eu";
  const pusher = new Pusher(pusherAppKey, {
    cluster: pusherCluster,
    encrypted: true
  });

  const channel = pusher.subscribe('user.' + userId);
  channel.bind('message.sent', function(data) {
    console.log(data);
    if (data.message.sender_id == senderId) {
      console.log('same user');
      const message = createOtherMessage(data.message);
      if (messageView.lastChild) {
        messageView.insertBefore(message, messageView.lastChild);
      } else {
        messageView.appendChild(message);
      }
      scrollToBottom();
    }
  });
}


  function scrollToBottom() {
    let messagesContainer = document.querySelector('.message-view');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }

  document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
    });

  addEventListeners();

  updateMessages();