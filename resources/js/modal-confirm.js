$(function(){

    var fnCrazy = {};
  
    
    $("[data-confirm]").on("click", function(evt){
    
        let modal = $('#modal'); 
        let btnClicked = $(this);
        let message = btnClicked.data("confirm");
        if(!message) return false;
        let title = (btnClicked.data("title")) ?  btnClicked.data("title"):'Success';
        let btnSave = (btnClicked.data("btn-save")) ? btnClicked.data("btn-cancel"):'Save' ;
        let btnCancel = (btnClicked.data("btn-cancel")) ? btnClicked.data("btn-cancel"):'Cancel'; 
        let classModal = (btnClicked.data("class")) ? btnClicked.data("class"):'success-modal';
        let callback = btnClicked.data("callback");
      
        if(modal.length){
            
            evt.preventDefault();    
            
            /* Fill fields of modal */ 
            if(classModal != null) modal.addClass(classModal);
            if(title != null) modal.find(".modal-title").html(title);
            if(message != null) modal.find(".modal-body").html(message);
            
            // Show cancel button 
            if(btnCancel != null) {
                $("#cancel").removeAttr("hidden");
                modal.find("#cancel").html(btnCancel);
            }
            
            
            // Check if have any functions for to call, function came of view and inserted at header before modal.js
            if(btnSave != null){
                let btnSaveModal = modal.find("#save");
                btnSaveModal.html(btnSave);
                
                btnSaveModal.one("click", function(evt2){
                    
                    if(callback !== undefined && callback !== ''){
                        
                        if(typeof callback === 'function')
                        {
                            callback(evt2);

                        }else if(typeof callback === 'string'){
                            try {
                                let fnCrazy = new Function(callback+"()");
                                if(typeof fnCrazy === 'function'){
                                    fnCrazy();
                                }    
                            } catch (error) {
                                console.log("Modal error:", error);
                               
                            }
                            
                        }
                    }else{// If have not a function, try submit the form or redirect for any page
                        if(btnClicked.attr("action")){
                            let evt = jQuery.Event( "submit" );
                            btnClicked.trigger(evt);
                        }else{
                            if(btnClicked.attr("ref") != undefined){
                                window.location.href = btnClicked.attr("ref");
                            } 
                            

                        }
                        
                        
                    }

                  
                    modal.modal("hide");

                });
            }
        }
            
        modal.modal("show");
        
    
    });


});