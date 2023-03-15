import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';
import { isValidForm } from '../js/helper/helper_functions';
import { showToast } from '../js/helper/sweetalert_helper';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['form']
    static values = {
        url: String
    }

    async submitForm(e) {

        e.preventDefault();

        if (!isValidForm(this.formTarget)) return;

        const formData = new FormData(this.formTarget);
        const url = this.urlValue ? this.urlValue : this.formTarget.getAttribute('action');
        const method = this.formTarget.getAttribute('method');

        try {
            await $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
            });

            this.dispatch('submitted-successfully');

        } catch (e) {
            showToast({ title: 'Something went wrong. Please try again.', icon: 'error', timer: 2000, customClass: 'sweetalert' });
            console.dir(e);
            this.dispatch('submitted-unsuccessfully');
        }

    }
}