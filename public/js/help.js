function addEventListeners() {
    let openHelpButton = document.querySelector('#open-help-button');
    if (openHelpButton) {
        openHelpButton.addEventListener('click', changeViewOpenHelp);
    }
    let closeHelpButton = document.querySelector('#close-help-button');
    if (closeHelpButton) {
        closeHelpButton.addEventListener('click', changeViewCloseHelp);
    }

}

document.addEventListener('DOMContentLoaded', function () {
    closeHelps = document.querySelector('.close-help');
    if (closeHelps)
        closeHelps.style.display = 'none';
});


function changeViewOpenHelp() {
    console.log('changeViewOpenHelp');
    const openButton = document.querySelector('#open-help-button');
    if(openButton.classList.contains('underline'))
        return;
    openButton.classList.add('underline');
    const closeButton = document.querySelector('#close-help-button');
    closeButton.classList.remove('underline');
    let openHelp = document.querySelector('div.open-help');
    let closeHelp = document.querySelector('div.close-help');
    if(closeHelp == null){
        openHelp = document.querySelector('table.open-help');
        closeHelp = document.querySelector('table.close-help');
        openHelp.style.display = 'table';
        closeHelp.style.display = 'none';
    }
    else{
        openHelp.style.display = 'block';
        closeHelp.style.display = 'none';
    }
}

function changeViewCloseHelp() {
    console.log('changeViewCloseHelp');
    const closeButton = document.querySelector('#close-help-button');
    if(closeButton.classList.contains('underline'))
        return;
    closeButton.classList.add('underline');
    const openButton = document.querySelector('#open-help-button');
    openButton.classList.remove('underline');
    let openHelp = document.querySelector('div.open-help');
    let closeHelp = document.querySelector('div.close-help');
    if(openHelp == null){
        openHelp = document.querySelector('table.open-help');
        closeHelp = document.querySelector('table.close-help');
        openHelp.style.display = 'none';
        closeHelp.style.display = 'table';
    }
    else{
        openHelp.style.display = 'none';
        closeHelp.style.display = 'block';
    }
}

addEventListeners();