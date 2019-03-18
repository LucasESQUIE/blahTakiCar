
let regexString = new RegExp("^(?=.*?[A-Za-z])[A-Za-z-éèàùôö ]+$");
let regexInt = new RegExp("^(?=.*?[0-9])[^a-zA-Z-.]+$");
let regexHeure = new RegExp("^([0-9]{2}h[0-9]{2})$");
//controle de la saisie du champ ville dep
let inputVilleDep = document.getElementById('villeDep');
inputVilleDep.addEventListener('blur', (e) => {
    verifString(inputVilleDep);
});

//controle de la saisie de la date de départ
// let inputDate = document.getElementById('dateDep');
// inputDate.addEventListener('blur', (e) => {
//     console.log(inputDate.value);
//    if(inputDate.value !== "") {
//        inputDate.classList.remove('invalid');
//    }else{
//        inputDate.classList.add('invalid');
//    }
// });


//controle de la saisie de l'heure de départ
let inputHeure = document.getElementById('heureDep');
inputHeure.addEventListener('blur', (e) => {
    if(regexHeure.test(inputHeure.value)) {
        inputHeure.classList.remove('invalid');
    }else{
        inputHeure.classList.add('invalid');
    }
});

//controle de la saisie de la ville d'arrivée
let inputVilleArr = document.getElementById('villeArr');
inputVilleArr.addEventListener('blur', (e) => {
    verifString(inputVilleArr);
});

//controle de la premiere ville etape
let inputEtape1 = document.getElementById('etape1');
inputEtape1.addEventListener('input', (e)=> {
   if(inputEtape1.value === "") {
       inputEtape1.classList.remove('invalid');
   }else{
       verifString(inputEtape1);
   }
});

//controle de la seconde ville étape
let inputEtape2 = document.getElementById('etape2');
inputEtape2.addEventListener('input', (e)=> {

    if(inputEtape2.value === "") {
        inputEtape2.classList.remove('invalid');
    }else{
        verifString(inputEtape2);
    }
});

//controle du nombre de place
let inputNbPlaces = document.getElementById("nbPlace");
inputNbPlaces.addEventListener('blur', (e)=> {
    if(regexInt.test(inputNbPlaces.value) && inputNbPlaces.value <= 7 && inputNbPlaces.value > 0 ) {
        inputNbPlaces.classList.remove('invalid');
    }else{
        inputNbPlaces.classList.add('invalid');
    }
});

//controle du prix
let inputPrix = document.getElementById("prix");
inputPrix.addEventListener('blur', (e) => {
    if(inputPrix.value === "") {
        inputPrix.classList.remove('invalid');
    }else if(regexInt.test(inputPrix.value)) {
        inputPrix.classList.remove('invalid');
    }else{
        inputPrix.classList.add('invalid');
    }
});


let form = document.getElementById('formProposer');
form.addEventListener('submit', (e) => {

    let inputs = form.getElementsByTagName('input');

    for(let i = 0; i < inputs.length; i++) {
        if(inputs[i].hasAttribute('required')) {
            if(inputs[i].value === "") {
                inputs[i].classList.add('invalid');
            }
        }
    }

});



function verifString(inputId) {

    if(regexString.test(inputId.value)) {
        inputId.classList.remove('invalid');
    }else{
        inputId.classList.add('invalid');
    }
}
