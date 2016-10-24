$('document').ready(function () {


    $('form').submit(function (event) {
        event.preventDefault();

        //Si les champs mots de passes ne sont pas vides , donc si on veux changer de mot de passe
        if ($('#mdpactu').val() !== "" || $('#mdpnew').val() !== "" || $('#mdpconf').val() !== "") {

            if ($('#mdpactu').val() !== $('#mdp').text() || $('#mdpnew').val() !== $('#mdpconf').val()) {
                alert('Vérifiez vos informations');


            } else {

                //On lance une requete ajax
                $.ajax({
                    url: 'modifprofil',
                    type: 'POST',
                    data: 'mdp=' + $('#mdpnew').val() + '&username=' + $('#adminbundle_user_username').val()
                            + '&pseudo=' + $('#adminbundle_user_pseudo').val() + '&nom=' + $('#adminbundle_user_nom').val() + '&prenom=' + $('#adminbundle_user_prenom').val()
                            + '&avatar=' + $('#adminbundle_user_avatar').val(),
                    dataType: 'text',
                    success: function (data, textStatus, jqXHR) {
                        var obj = $.parseJSON(data);
                        alert(obj.reussite);

                    }
                });
            }
        } else {
            $.ajax({
                url: 'modifprofil',
                type: 'POST',
                data: 'mdp=' + $('#mdpnew').val() + '&username=' + $('#adminbundle_user_username').val()
                        + '&pseudo=' + $('#adminbundle_user_pseudo').val() + '&nom=' + $('#adminbundle_user_nom').val() + '&prenom=' + $('#adminbundle_user_prenom').val()
                        + '&avatar=' + $('#adminbundle_user_avatar').val(),
                dataType: 'text',
                success: function (data, textStatus, jqXHR) {
                    var obj = $.parseJSON(data);
                    alert(obj.reussite);

                }
            });

        }

    });
});