let id;
let display_state = {};

function example(ele){
    let id = ele.id;
    //ele.innerHTML= 'area element id = ' + id;

    //check if id is already in display_state
    //https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty
    if(!display_state.hasOwnProperty(id)){
        display_state[id] = 0;
    }

    //https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dataset
    if(!ele.dataset.has_listener){
        //add event listener for click
        ele.addEventListener('click', handle_click);

        //handle click
        function handle_click(event){
            //event.preventDefault();
            //event.stopPropagation();
            //call display
            display_state[id] = display_message(display_state[id], id);
        }
        //update key value to true for has_listener
        ele.dataset.has_listener = true;
    }
   
}

function display_message(show, id){
    //get id of conversation
    let convo_id = id;
    //format for specific id of conversation container
    convo_id = 'box'+ convo_id;
    let convo = document.querySelector('#' + convo_id);

    //check if shown
    if(show == 1){
        //hide and return value as hidden
        convo.style.display = 'none';
        show = 0;
        return show
    }
    //check if hidden
    if (show == 0){
        //show and return value as shown
        convo.style.display = 'flex';
        show = 1
        return show
    }
}
