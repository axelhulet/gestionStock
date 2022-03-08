import {Controller} from "@hotwired/stimulus";
import toastr from 'toastr';

// un controller doit impérativement etre enregisté dans bootstrap.js
export default class extends Controller {
    // cette méthode n'est appelée que si l'html
    // possède une div qui possède l'attribut: data-controller="toastr"
    connect() {
        // la div qui a été utilisé pour appelée le controller

        // recupère l'attibut message de la div
        // let message = this.element.getAttribute('data-message');
        // let status = this.element.getAttribute('data-status');

        // forme raccourci en javascript pour recupérer les attributs data-...
        const { message, status } = this.element.dataset;

        toastr[status](message);
    }
}