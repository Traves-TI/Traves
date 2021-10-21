$(function(){
    /**
     * @param {*} url 
     * @param {*} method 
     * @param {*} data 
     * @returns data or false for ajax requests
     */
     function makeAjax(url, method, data = {}){
      
        if(url != null && method != null){
            $.ajax({
                method: method,
                url: url,
                data : data               
            }).done(function(msg){
                alert(msg);
            });
        }
         return false;
    }
});
