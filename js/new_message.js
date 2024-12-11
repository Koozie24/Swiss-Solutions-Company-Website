function toggle_newmessage(counter_message){
    let message = document.querySelector('.new-message');

    if((counter_message % 2) == 1){
        message.style.display = 'none';
    }
    if ((counter_message % 2) == 0){
        message.style.display = 'flex';
    }
    counter_message += 1;

    return counter_message
}

let counter_message = 0;

//for refresher: https://stackoverflow.com/questions/75311856/how-can-i-change-the-css-display-property-when-clicking-on-a-link-button

let msg_btn = document.querySelector('.auth-message');

msg_btn.addEventListener('click', function(event){
    event.preventDefault();
    counter_message = toggle_newmessage(counter_message);
    console.log(counter_message)
})