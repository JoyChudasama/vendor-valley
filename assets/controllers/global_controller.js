import { Controller } from '@hotwired/stimulus';
import { hideFlash } from '../js/helper/flash_helper';


/* stimulusFetch: 'lazy' */
export default class extends Controller {

    hideFlash(e) {
        e.preventDefault();
        hideFlash();
    }
    
    updateCartItemsCount(e){
        e.preventDefault();
        
        const params = e.detail
        
        console.log(params)
    }


}