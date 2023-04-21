import { Controller } from '@hotwired/stimulus';
import { showFlash } from '../js/helper/flash_helper';
import $ from 'jquery';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['cartItemQuantityInput'];

    async increaceCartItemQuantity(e) {
        e.preventDefault();
        await this.getJsonAndDispatchEvents(e.params.increaseCartItemQuantityUrl);
    }

    async decreaseCartItemQuantity(e) {
        e.preventDefault();
        await this.getJsonAndDispatchEvents(e.params.decreaseCartItemQuantityUrl);
    }

    async removeItem(e) {
        e.preventDefault();
        await this.getJsonAndDispatchEvents(e.params.removeCartItemUrl);
    }

    async getJsonAndDispatchEvents(url) {
        try {
            const res = await $.getJSON(url);

            this.dispatch('event_updateCart');
            this.dispatch('event_updateCartItemsCount');

            showFlash(res.type, res.message);
        } catch (e) {
            const res = e.responseJSON;
            return showFlash(res.type, res.message);
        }
    }
}