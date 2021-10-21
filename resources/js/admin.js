$(function(){
    $("[name='dataTable_length']").on("change", function(){
        let option = $(this).val();
        let current_url = window.location.href;

        if(current_url.indexOf("?") === -1){
            current_url += "?entries="+option; 
        }else{
            if(current_url.indexOf("entries") === -1){
                current_url += "?entries="+option;
            }else{
                current_url = current_url.replace(/entries=\d+/, 'entries='+option);
            }
        }
       
       window.location = current_url; 
       
    });
});