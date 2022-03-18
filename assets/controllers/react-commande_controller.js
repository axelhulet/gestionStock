import {Controller} from "@hotwired/stimulus";
import ReactDOM from 'react-dom';
import  React, {useState} from "react";
import axios from "axios";

export default class extends Controller {
    connect() {
        const {id} = this.element.dataset;
        ReactDOM.render(<App id={id}/>, this.element);
    }
}

const App = ({id}) => {
    const [produitId, setProduitId] = React.useState('');
    const [quantity, setQuantity] = React.useState('');
    const [lignes, setLignes] = React.useState([]);
    const [choix, setChoix] = React.useState([]);

    React.useEffect(() => {
    //    le code ici ne sera exécuté une seul fois a l'initialisation du composant
        axios.get('http://127.0.0.1:8000/commandes/lines/' + id)
            .then(({data}) => setLignes(data));
    }, []);

    const onClick =() =>{
        let fd = new FormData();
        fd.append('produitId', produitId);
        fd.append('quantity', quantity);
        axios.post('http://127.0.0.1:8000/commande/add_line/' + id, fd)
            .then(({data}) => {
                //data correspond aux données renvoyées par le server
                // console.log(data);
                setLignes(data);
            });
    }

    const onInput = e => {
        let name = e.target.value;
        axios.get('http://127.0.0.1:8000/produit/search?name=' + name)
            .then(({data}) => setChoix(data));
    }

    return <div>
        <h3>Lignes de commande</h3>
        <div className={'row'}>
            <div className={'col-md-6'}>
                <label>Produit</label>
                <input className={'form-control'}
                       onChange={e=> setProduitId(e.target.value)}
                        onInput={onInput}
                       list={'choix'}
                />
                <datalist id={'choix'}>
                    { choix.map(c => <option key={c.id} value={c.id}>
                        {c.nom + ' stock:' + c.stock + ' prix:' + c.prix}
                        </option>)}
                </datalist>
            </div>
            <div className={'col-md-6'}>
                <label>Quantité</label>
                <input className={'form-control'} onChange={e=> setQuantity(e.target.value)}/>
            </div>
        </div>
        <button className={'btn btn-primary orange mt-2'} onClick={onClick}>Ajouter</button>
        <table className={'table'}>
            <thead>
                <tr>
                   <th>Produit</th>
                    <th>quantité</th>
                    <th>Prix unitaire</th>
                    <th>Sous total</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
            { lignes.map(l => <tr>
                <td>{l.produitRef}</td>
                <td>{l.quantite}</td>
                <td>{l.prix}</td>
                <td>{l.prixTotal.toFixed(2)}</td>
                <td></td>
                </tr>)}
            </tbody>
        </table>
    </div>
}