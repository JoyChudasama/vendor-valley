import { Controller } from '@hotwired/stimulus';
import { showFlash } from '../js/helper/flash_helper';
import $ from 'jquery';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['cartItemQuantityInput'];
    cartItemQuantity = 0;
    minCartItemQuantity = 1;

    connect() {
        this.cartItemQuantity = parseInt(this.cartItemQuantityInputTarget.value);
    }

    async increaceCartItemQuantity(e) {
        e.preventDefault();

        const params = e.params;

        try {
            const res = await $.getJSON(params.increaseCartItemQuantityUrl);

            this.dispatch('event_updateCart');
            this.dispatch('event_updateCartItemsCount');

        } catch (e) {
            const res = e.responseJSON;
            return showFlash(res.type, res.message);
        }
    }
    
    async decreaseCartItemQuantity(e) {
        e.preventDefault();

        const params = e.params;

        try {
            const res = await $.getJSON(params.decreaseCartItemQuantityUrl);

            this.dispatch('event_updateCart');
            this.dispatch('event_updateCartItemsCount');

        } catch (e) {
            const res = e.responseJSON;
            return showFlash(res.type, res.message);
        }
    }

    async removeItem(e) {
        e.preventDefault();

        const params = e.params;

        try {
            const res = await $.getJSON(params.removeCartItemUrl);

            this.dispatch('event_updateCart');
            this.dispatch('event_updateCartItemsCount');

            showFlash(res.type, res.message);
        } catch (e) {
            const res = e.responseJSON;
            return showFlash(res.type, res.message);
        }
    }
}