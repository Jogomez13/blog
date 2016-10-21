$('document').ready(function(){
    
    
    $('form').submit(function(event){
        
        if($('#mdpactu').val() !== $('#mdp').text() || $('#mdpnew').val() !== $('#mdpconf').val() ){
            alert('Vérifiez vos informations');
            event.preventDefault();
            
        }

    });
});