$('document').ready(function () {
$('#adminbundle_user_password').css('display' , 'none');

    $('#submit').click(function () {//A l'envoi du formulaire

            //Si les champs ne sont pas remplis correctement ou vides
            if ($('#mdpactu').val() !== $('#mdp').text() || $('#mdpnew').val() !== $('#mdpconf').val() || $('#mdpactu').val() === "" || $('#mdpnew').val() === "" || $('#mdpconf').val() === "") {
                
                alert('Vérifiez vos informations');
            } else {

                //On lance une requete ajax pour envoyer les valeurs des champs
                $.ajax({
                    url: 'modifPass',
                    type: 'POST',
                    data: 'mdp=' + $('#mdpnew').val(),
                    dataType: 'text',
                    success: function (data, textStatus, jqXHR) {
                        var obj = $.parseJSON(data);//Retour des données en format Json
                        alert(obj.reussite);//Affichage

                    }
                });
            }
        

    });
});
