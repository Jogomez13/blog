$('document').ready(function () {


    $('form').submit(function (event) {//A l'envoi du formulaire


        //Si au moins un des champs mots de passes n'est pas vide , donc si on veux changer de mot de passe
        if ($('#mdpactu').val() !== "" || $('#mdpnew').val() !== "" || $('#mdpconf').val() !== "") {

            //Si les champs ne sont pas remplis correctement ou vides
            if ($('#mdpactu').val() !== $('#mdp').text() || $('#mdpnew').val() !== $('#mdpconf').val() || $('#mdpactu').val() === "" || $('#mdpnew').val() === "" || $('#mdpconf').val() === "") {
                event.preventDefault();
                alert('Vérifiez vos informations');
            } else {

                //On lance une requete ajax pour envoyer les valeurs des champs
                $.ajax({
                    url: 'modifprofil',
                    type: 'POST',
                    data: 'mdp=' + $('#mdpnew').val(),
                    dataType: 'text',
                    success: function (data, textStatus, jqXHR) {
                        var obj = $.parseJSON(data);//Retour des données en format Json
                        alert(obj.reussite);//Affichage

                    }
                });
            }
        }

    });
});