$('document').ready(function(){
   
   $('#valider').click(function(){
      alert('test');
      $.ajax({
            url: 'inscription',
            type: 'POST',
            data: 'username=' + $('#user_username').val() + '&password=' + $('#user_password').val() +
                    '&mail=' + $('#user_mail').val(),
            dataType: 'text',
            success: function (data, textStatus, jqXHR) {
                var obj = $.parseJSON(data);
                
            }
        });
       
   });
    
});


