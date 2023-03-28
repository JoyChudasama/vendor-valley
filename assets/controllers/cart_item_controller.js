import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['cartItemQuantityInput'];
    cartItemQuantity = 0;
    minCartItemQuantity = 1;

    connect() {
        this.cartItemQuantity = parseInt(this.cartItemQuantityInputTarget.value);
    }

    decreaseCartItemQuantity(e) {
        e.preventDefault();

        if (this.cartItemQuantity === this.minCartItemQuantity) return;

        this.cartItemQuantity -= 1;
        this.cartItemQuantityInputTarget.value = this.cartItemQuantity;
    }

    increaceCartItemQuantity(e) {
        e.preventDefault();
        this.cartItemQuantity += 1
        this.cartItemQuantityInputTarget.value = this.cartItemQuantity;
    }
}