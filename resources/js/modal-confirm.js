$(function(){
   
    function oi(){
        return alert("oi");

    }


    $("[data-confirm]").on("click", function(e){
        
        let modal = $('#modal'); 
        let message = $(this).data("confirm");
        let title = $(this).data("title");
        let btnSave = $(this).data("btn-save");
        let btnCancel = $(this).data("btn-cancel");
        let classModal = $(this).data("class");
        let callback = $(this).data("callback");
        
        if(modal.length){
            /* Fill fields of modal */ 
            if(classModal != null) modal.addClass(classModal);
            if(title != null) modal.find(".modal-title").html(title);
            if(message != null) modal.find(".modal-body").html(message);
           
            // Show cancel button 
            if(btnCancel != null) {
                $("#cancel").removeAttr("hidden");
                modal.find("#cancel").html(btnCancel);
            }

            // Check if have any functions for to call
            if(btnSave != null){
                modal.find("#save").html(btnSave);
                if(callback != null){
                    
                    var CallbackFunction = new Function();
                    console.log(CallbackFunction, callback);

                    if(typeof CallbackFunction === 'function'){
                        return CallbackFunction;
                    }
                }
            }
            
            
        }

        e.preventDefault();
        modal.modal("show");
        
        
        
    });

});