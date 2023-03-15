import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['refreshContent'];

    static values = {
        refreshUrl: String
    };

    async reloadContent(e) {
        const target = this.hasContentTarget ? this.contentTarget : this.element;
        const response = await $.ajax({
            url: this.urlValue
        });

        target.innerHTML = response;
    }
}
