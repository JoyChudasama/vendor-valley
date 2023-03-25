import { Controller } from '@hotwired/stimulus';
import { hideFlash } from '../js/helper/flash_helper';
import $, { param } from 'jquery';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['numberOfCartItems'];

    static values = {
        numberOfCartItemsUrl: String
    }

    connect(){
        $.get(this.numberOfCartItemsUrlValue).then((res)=>this.numberOfCartItemsTarget.innerHTML = res.numberOfItems)
    }

    hideFlash(e) {
        e.preventDefault();
        hideFlash();
    }

    updateCartItemsCount(e) {
        e.preventDefault();

        const params = e.detail;
        this.numberOfCartItemsTarget.innerHTML  = params.numberOfItems;
    }


}