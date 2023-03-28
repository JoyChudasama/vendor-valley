import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';
import { showFlash } from '../js/helper/flash_helper';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    async addToCart(e) {
        e.preventDefault();

        const params = e.detail;

        try {
            const res = await $.getJSON(params.url);

            showFlash(res.type, res.message);

            this.dispatch('event_updateCartItemsCount', { detail: { numberOfItems: res.cart.numberOfItems } });

        } catch (e) {
            const res = e.responseJSON;
            return showFlash(res.type, res.message);
        }
    }

    async clearCart(e) {
        e.preventDefault();
        
        const params = e.params;

        try {
            const res = await $.getJSON(params.clearCartUrl);

            showFlash(res.type, res.message);

            this.dispatch('event_updateCart');
            this.dispatch('event_updateCartItemsCount', { detail: { numberOfItems: res.cart.numberOfItems } });

        } catch (e) {
            const res = e.responseJSON;
            return showFlash(res.type, res.message);
        }

    }
}