import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';
import { isValidForm } from '../js/helper/helper_functions';
import { addLoadingSpinner, removeLoadingSpinner } from '../js/helper/loading_spinner_helper';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['submitButtonDiv', 'submitButton'];

    add() {
        const submitButton = this.submitButtonTarget

        addLoadingSpinner(this.submitButtonDivTarget);

        const forms = $.find('form');

        forms.forEach(form => {
            if (!isValidForm(form)) {
                this.submitButtonDivTarget.append(submitButton);
                removeLoadingSpinner(this.submitButtonDivTarget);
            }
        });
    }
}