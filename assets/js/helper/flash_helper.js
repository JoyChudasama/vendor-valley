const showFlash = (type, message) => {

    const flashElement = document.getElementById('js-flash');
    const alert = flashElement.getElementsByClassName('alert')[0];
    const flashMessage = flashElement.getElementsByTagName('span')[0];

    alert.classList.add(`alert-${type}`);
    flashMessage.innerHTML = message;

    flashElement.classList.remove('d-none');
}


const hideFlash = () => {
    document.getElementById('js-flash').classList.add('d-none');
}


export { showFlash, hideFlash };