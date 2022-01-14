$(function(){

    var fnCrazy = {};
  

    $("[data-confirm]").on("click", function(evt){
      
        let modal = $('#modal'); 
        let btnClicked = $(this);
        let message = btnClicked.data("confirm");
        let title = btnClicked.data("title");
        let btnSave = btnClicked.data("btn-save");
        let btnCancel = btnClicked.data("btn-cancel");
        let classModal = btnClicked.data("class");
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
                
                btnSaveModal.one("click", function(){
                    
                    if(callback !== null && callback !== ''){
                        let fnCrazy = {};
                        fnCrazy = new Function(callback+"()");
                        if(typeof fnCrazy === 'function'){
                            fnCrazy();
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
                });
            }
        }
            
        modal.modal("show");
        
    
    });


});