function toggle_sidebar(count){
    let sidebar = document.querySelector('.icon-bar');

    if((count % 2) == 1){
        sidebar.style.display = 'none';
    }
    if ((count % 2) == 0){
        sidebar.style.display = 'block';
    }
    count += 1;

    return count
}


let count = 0;

//for refresher: https://stackoverflow.com/questions/75311856/how-can-i-change-the-css-display-property-when-clicking-on-a-link-button

let button = document.querySelector('.burger-link');

button.addEventListener('click', function(event){
    event.preventDefault();
    count = toggle_sidebar(count);
    console.log(count)
})

