import { Controller } from '@hotwired/stimulus';
import { hideFlash } from '../js/helper/flash_helper';
import $, { param } from 'jquery';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['numberOfCartItems'];

    static values = {
        numberOfCartItemsUrl: String
    }

    connect() {
        this.updateCartItemsCount();
    }

    hideFlash(e) {
        e.preventDefault();
        hideFlash();
    }

    updateCartItemsCount(e) {
        e && e.preventDefault();
        
        $.get(this.numberOfCartItemsUrlValue).then((res) => this.numberOfCartItemsTarget.innerHTML = res.numberOfItems)
    }

}