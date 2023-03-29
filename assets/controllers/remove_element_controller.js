import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = ['element'];

    remove(e) {
        e.preventDefault();
        this.elementTarget.remove();
    }
}