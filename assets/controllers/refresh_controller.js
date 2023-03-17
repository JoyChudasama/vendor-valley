import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['refreshContent'];

    static values = {
        refreshUrl: String
    };

    async reloadContent() {

        const target = this.hasRefreshContentTarget ? this.refreshContentTarget : this.element;
        const response = await $.ajax({
            url: this.refreshUrlValue
        });

        target.innerHTML = response;
    }
}
