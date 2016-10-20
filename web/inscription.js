$('document').ready(function () {

    $('#valider').click(function () {
        //Si les mots de passes correspondent
        if ($('#password').val() === $('#conf_password').val())
        {
            //Et si les champ ne sont pas vides //
            if ($('#password').val() !== "" && $('#conf_password').val() !== "" && $('#email').val() !== "" && $('#prenom').val() !== "" && $('#nom').val() !== "") {
                 
                //On lance une requete ajax
                $.ajax({
                    url: 'inscription',
                    type: 'POST',
                    data: 'username=' + $('#email').val() + '&password=' + $('#password').val() +
                            '&nom=' + $('#nom').val() + '&prenom=' + $('#prenom').val(),
                    dataType: 'text',
                    success: function (data, textStatus, jqXHR) {
                        var obj = $.parseJSON(data);
                        alert(obj.reussite);

                    }
                });
            } else {
                alert('Ils vous manquent des informations !');
            }
        } else {
            alert('Les mots de passes ne correspondent pas !');
        }
    });
});


