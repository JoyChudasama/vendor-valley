import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

export default class extends Controller {

    static targets = ['form', 'editButton', 'submitButton', 'cancelButton', 'deleteButton']

    connect() {
        this.disableAllInputs();
    }

    enableAllInputs(e) {

        e.preventDefault();

        const inputs = $('textarea, input, select');

        inputs.each((i, e) => {
            e.removeAttribute('disabled');
        });

        this.editButtonTarget.classList.add('d-none');
        this.hasSubmitButtonTarget && this.submitButtonTarget.classList.remove('d-none');
        this.cancelButtonTarget.classList.remove('d-none');
        this.hasDeleteButtonTarget && this.deleteButtonTarget.classList.remove('d-none');
    }

    disableAllInputs(e) {

        e && e.preventDefault();

        const inputs = $('textarea, input, select');

        inputs.each((i, e) => {
            e.setAttribute('disabled', '');
        });

        this.hasSubmitButtonTarget && this.submitButtonTarget.classList.add('d-none');
        this.cancelButtonTarget.classList.add('d-none');
        this.hasDeleteButtonTarget && this.deleteButtonTarget.classList.add('d-none');
        this.editButtonTarget.classList.remove('d-none');
    }
}