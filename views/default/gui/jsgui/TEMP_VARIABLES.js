var TEMP_VAR = (function(){
    this.TEMP='';
    this.TEMP_VAR=(function(){
        return this.TEMP;
    });
    this.SET_TEMP = (function(v){
        this.TEMP = v;
    });
});