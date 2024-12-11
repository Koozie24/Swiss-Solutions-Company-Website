function toggle_dropmenu(counter){
    let user_sidebar = document.querySelector('.account-menu');

    if((counter % 2) == 1){
        user_sidebar.style.display = 'none';
    }
    if ((counter % 2) == 0){
        user_sidebar.style.display = 'block';
    }
    counter += 1;

    return counter
}

let counter = 0;

//for refresher: https://stackoverflow.com/questions/75311856/how-can-i-change-the-css-display-property-when-clicking-on-a-link-button

let user_button = document.querySelector('.user-btn');

user_button.addEventListener('click', function(event){
    event.preventDefault();
    counter = toggle_dropmenu(counter);
    console.log(counter)
})