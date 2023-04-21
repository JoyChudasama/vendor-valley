import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';
import { showFlash } from '../js/helper/flash_helper';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    async clearCart(e) {
        e.preventDefault();
        
        const params = e.params;

        try {
            const res = await $.getJSON(params.clearCartUrl);
            
            this.dispatch('event_updateCart');
            this.dispatch('event_updateCartItemsCount');
            
            showFlash(res.type, res.message);
        } catch (e) {
            const res = e.responseJSON;
            return showFlash(res.type, res.message);
        }
    }
}