function addHTTP(id) {
  r = new RegExp();
  r = /^(http\:\/\/|ftp\:\/\/|https\:\/\/)/;
  val = document.getElementById(id).value;
  if (val!=""){
    if (!r.test(val)){
      document.getElementById(id).value = "http://"+val;
    }
  }
}
var francaisDatatable = {
    "sProcessing":     "Traitement en cours...",
    "sSearch":         "Rechercher&nbsp;:",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
    "sInfoPostFix":    "",
    "sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
    "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
    },
    "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
    }
};
function controlerInput(valeur , min , max) {
  if (valeur.length < min || valeur.length > max){
    return false;
  }else {
    return true;
  }
}
function controlerEmail(id , regex) {
  tag = document.getElementById(id);

  regexEmail = new RegExp();
  regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9\._-]{2,}\.[a-z]{2,6}$/;

  classes = document.querySelectorAll('span.error');
  if (classes.length !=0){
    for (let i=0 ; i<classes.length ; i++) {
      classes[i].remove();
    }
  }
  if ((regex == "email") && (!regexEmail.test(tag.value.trim()))){
    tag.style.borderColor = "red";
    tag.style.color = "red";
      span = document.createElement("span");
      span.innerText = "Ce champ n'est pas un email";
      span.className = "error";
      span.style.color = "red";
      tag.parentElement.parentElement.appendChild(span);
      retour = false;
  }else {
    retour = true;
  }
  return retour;
}
function validate(id , min , max , regex , equal){

  tag = document.getElementById(id);

  regexEmail = new RegExp();
  regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9\._-]{2,}\.[a-z]{2,6}$/;

  regexTel = new RegExp();
  regexTel = /^((\()?(\+)?[0-9]{1,5})(\))?( )?([0-9]{1,4}( |-)?){2,5}$/;

  regexNumber = new RegExp();
  regexNumber = /^([0-9]{1,3}\.{0,1}(,{0,1})[0-9]{1,3})+$/;

  regexSiteWeb = new RegExp();
  regexSiteWeb = /^(http\:\/\/|ftp\:\/\/|https\:\/\/)?([a-zA-Z0-9]{2,4}.)([a-zA-Z0-9\.\-\_]){2,}\.([a-z]{2,4})(\/([a-zA-Z0-9\/\?=\-_]){0,})?$/;

  regexString = new RegExp();
  regexString = /[a-zA-Z_]/;

  regexNombre = new RegExp();
  regexNombre = /[0-9]/;

  regexSpecialChar = new RegExp();
  regexSpecialChar = /[^a-zA-Z_0-9]/;

  retour = true;
  /*if (document.querySelectorAll("span.error").length != 0){
      tag.parentElement.removeChild(document.querySelector('.error'));
  }*/
  classes = document.querySelectorAll('#'+id+' ~ span.error');
  if (classes.length !=0){
    for (let i=0 ; i<classes.length ; i++) {
      tag.parentNode.removeChild(classes[i]);
    }
  }

  if (tag.value.trim().length==0){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Ce champ ne peut pas être vide";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if (max==0 && tag.value.trim().length < min){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Ce champ doit contenir au minimum "+min+" caractères";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if (tag.value.trim().length > max && min==0){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Ce champ doit contenir au maximum "+maximum+" caractères";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if ((tag.value.trim().length < min && min!=0) || (max!=0 && tag.value.trim().length > max)){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Ce champ doit contenir entre "+min+" et "+max+" caractères";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if ((regex == "email") && (!regexEmail.test(tag.value.trim()))){
    tag.style.borderColor = "red";
    tag.style.color = "red";
      span = document.createElement("span");
      span.innerText = "Ce champ n'est pas un email";
      span.className = "error";
      span.style.color = "red";
      tag.parentElement.appendChild(span);
      retour = false;
  }else if ((regex == "tel") && (!regexTel.test(tag.value.trim()))){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Ce champ n'est pas un numéro de téléphone";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if ((regex == "siteweb") && (!regexSiteWeb.test(tag.value.trim()))){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Ce champ n'est pas une url de site web";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if ((regex == "number") && (!regexNumber.test(tag.value.trim()))){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Ce champ une monnaie";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if ((regex == "password") && (!regexString.test(tag.value.trim()))){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Le mot de passe doit contenir une chaine de caractère";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if ((regex == "password") && (!regexNombre.test(tag.value.trim()))){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Le mot de passe doit contenir un numérique";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if ((regex == "password") && (!regexSpecialChar.test(tag.value.trim()))){
    tag.style.borderColor = "red";
    tag.style.color = "red";
    span = document.createElement("span");
    span.innerText = "Le mot de passe doit contenir des caractères spéciaux";
    span.className = "error";
    span.style.color = "red";
    tag.parentElement.appendChild(span);
    retour = false;
  }else if (equal!="" && (tag.value.trim() != document.getElementById(equal).value.trim())){
      tag.style.borderColor = "red";
      tag.style.color = "red";
      span = document.createElement("span");
      span.innerText = "Ces deux champs doivent être les mêmes";
      span.className = "error";
      span.style.color = "red";
      tag.parentElement.appendChild(span);
      retour = false;
  }else {
    tag.style.borderColor = "";
    tag.style.color = "";
    //document.removeElement(span);
    retour = true;
  }
  return retour;
}
/*
function listener(e){
    e.preventDefault();
    if (validate(id,min,max,regex,equal)){
      tag.removeEventListener('focusout',listener);
    }
}

function listenerSelect(e) {
  e.preventDefault();
  if (validateSelect(id,type)){
    tag.removeEventListener('focusout',listenerSelect);
  }
}

function endvalidate(id){
  tag = document.getElementById(id);
  tag.removeEventListener('focusout',function (e) {
    e.preventDefault();
    validate(id,min,max,regex,equal);
  });
  tag.style.borderColor = "";
  tag.style.color = "";
}
*/
function validateSelect(id, type){


    retour = true;

    if (type == "id"){
      tag = document.getElementById(id);
      classes = document.querySelectorAll('#'+id+' ~ span.error');
      if (classes.length !=0){
        for (let i=0 ; i<classes.length ; i++) {
          tag.parentNode.removeChild(classes[i]);
        }
      }
      if (tag.value.trim()==""){
        tag.style.borderColor = "red";
        span = document.createElement("span");
        span.innerText = "Ce champ ne peut pas être vide";
        span.className = "error";
        span.style.color = "red";
        tag.parentElement.appendChild(span);
        retour = false;
      }else {
        tag.style.borderColor = "";
        tag.style.color = "";
        retour = true;
      }
    }else if (type == "class") {
      tag = document.getElementById(id);
      classes = document.querySelectorAll('#'+id+' ~ span.error');
      if (classes.length !=0){
        for (let i=0 ; i<classes.length ; i++) {
          tag.parentNode.removeChild(classes[i]);
        }
      }

      i = 0;
      if ($('.'+id).val() == null || $('.'+id).val() == undefined){
        i++;
      }else {
        for (let element of $('.'+id).val()) {
          if (element==""){
            i++;
          }
        }
      }
      if (i == 0){
        tag.style.borderColor = "";
        tag.style.color = "";
/*        tag.addEventListener('focusout',listenerSelect);*/
        retour = true;
      }else if (i == 1){
        tag.style.borderColor = "red";
        span = document.createElement("span");
        span.innerText = "Ce champ n'est pas valide";
        span.className = "error";
        span.style.color = "red";
        tag.parentElement.appendChild(span);
        retour = false;
      }
    }
    return retour;
}

function endValidateSelect(id,type){
    classes = document.querySelectorAll('#'+id+' ~ span.error');
    if (classes.length !=0){
      for (let i=0 ; i<classes.length ; i++) {
        tag.parentNode.removeChild(classes[i]);
      }
    }
      tag.style.borderColor = "";
      tag.style.color = "";
  }
