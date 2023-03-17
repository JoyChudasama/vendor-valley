import $ from 'jquery';

// Will remove everything from the given divElement and append loading spinner
const addLoadingSpinner = (divElement) => {

    divElement.innerHTML = '';

    let loader = `
        <div class="spinner-border text-primary loading-spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `
    $(divElement).append(loader);
}

// Will remove loading spinner
const removeLoadingSpinner = (divElement) => {
    const spinner = $(divElement).find('.loading-spinner');

    spinner && spinner.remove();
}

export { addLoadingSpinner, removeLoadingSpinner };


