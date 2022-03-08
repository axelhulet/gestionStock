import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        //  message de confirmation ou annulation modal
        const modal = document.getElementById('my-modal');
        const confirmButton = document.getElementById('confirm-button');
        let href;

        modal.addEventListener('show.bs.modal', e=> {
            href = e.relatedTarget.getAttribute('href');

        })
        confirmButton.addEventListener('click', e=> {
            window.location.href = href;
        })
    }


}