import { Controller } from '@hotwired/stimulus';
import { isSame } from '../js/helper/helper_functions';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['emailInput', 'confirmEmailInput', 'passwordInput', 'confirmPasswordInput', 'submitButton']

    matchEmail() {
        const doesEmailMatch = isSame(this.emailInputTarget.value, this.confirmEmailInputTarget.value)

        if (!doesEmailMatch) {
            this.confirmEmailInputTarget.classList.add('is-invalid');
            this.submitButtonTarget.setAttribute('disabled', '');
            return;
        }

        this.confirmEmailInputTarget.classList.remove('is-invalid');
        this.submitButtonTarget.removeAttribute('disabled');
    }

    matchPassword() {
        const doesEmailMatch = isSame(this.passwordInputTarget.value, this.confirmPasswordInputTarget.value)

        if (!doesEmailMatch) {
            this.confirmPasswordInputTarget.classList.add('is-invalid');
            this.submitButtonTarget.setAttribute('disabled', '');
            return;
        }

        this.confirmPasswordInputTarget.classList.remove('is-invalid');
        this.submitButtonTarget.removeAttribute('disabled');
    }
}
