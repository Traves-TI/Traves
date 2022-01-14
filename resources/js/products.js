
$(function(){

    let $file = $("input[type='file']");
    let $imagesPreview = $(".imgPreview");

    function validator($file) {
        if($file == null || $file.size == null || $file.type == null) return false;
     
        $MIMES = ["gif","png", "jpeg", "jpg"]; 

        // Temos o file
        $fileSize = Math.ceil($file.size / 1024 / 1024);
        $fileType = ($file.type).split("/");
        $fileType = $fileType[$fileType.length - 1];
        $message = "";
        
        if($fileSize > 2 || $MIMES.find(el => el === $fileType) == undefined){ 
            $message = ($fileSize > 2) ? '{{__("File size exceeds the limit allowed and cannot be saved")}}' + "</br>" : "";
            $message += ($MIMES.find(el => el === $fileType) == undefined) ? '{{__("File type donts allowed and cannot be saved")}}': "";
            $("[data-confirm]").data("confirm", $message).trigger("click");
            return false;

         
        }
      
        return true;
    }

    function restartFields($container, $image, $label, $textError = null){
     
        $container.parent().find("input[type=file]").val("");
        
        /*    $("input[name='cover']").val("");
        $("input[name='image']").val("");
*/
        $container.attr("hidden", "true");
        $image.attr("src","");
        $label.html($label.attr("data-message"));

        if($textError != null && $textError.hasClass("text-success")){
            $textError.removeClass("text-success").addClass("text-danger");
        }
               
        return true;
                
    }
/* Preview and front validation of image */
        $file.on("change", function(e){
            $containerFile = $(this).parent();
            $containerImage = $containerFile.find(".containerImage");
            $image = $containerImage.find(".imgPreview");
            $textError = $containerFile.find(".errorImg");
            $label = $(this).next("label");
            $fileUploaded = e.target.files[0];

            if($fileUploaded){
                    if(validator($fileUploaded)){
                        $textError.removeClass("text-danger").addClass("text-success");
                        $fileURL = URL.createObjectURL($fileUploaded);
                        $imageName = $fileUploaded.name;
                        $label.text($imageName);
                        $containerImage.removeAttr("hidden");
                        $image.attr("src",$fileURL);
                    }else{
                        restartFields($containerImage, $image, $label, $textError);
                    }

                    
            }
                    

    });


    $clickedTrashed = $(".imageDelete");
    $clickedTrashed.on("click", function(e){
        e.preventDefault();
        $containerImage = $(this).parent();
        $image = $containerImage.find(".imgPreview");
        $label = $containerImage.parent().find("label");
        restartFields($containerImage, $image, $label, null);
    });

/* we know the intenciÓn when the image is deleted by client :P */  
    $("#btnSend").on("click", function (e) {
        // passar pelas img e verificar a src é diferente de nullo se sim alterar o valor do input para a src
        $imagesPreview.each(function(){
            if($(this).attr("src") != ""){
                $(this).next("input").val($(this).attr("src"));
            }
        });
    });

 
});