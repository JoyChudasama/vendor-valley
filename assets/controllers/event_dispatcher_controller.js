import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    dispatchAddToCart(e) {
        e.preventDefault();
        this.dispatch('event_addToCart', { detail: e.params });
    }

    dispatchHideFlash(e) {
        e.preventDefault();
        this.dispatch('event_hideFlash', { detail: e.params });
    }
    
    dispatchUpdateCartItemsCount(e){
        e.preventDefault();
        this.dispatch('event_updateCartItemsCount', { detail: e.params });
    }
}