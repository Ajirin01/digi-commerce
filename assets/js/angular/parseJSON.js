myApp.filter('parseJSON', function(){
    return (string) => {
        if(string == undefined){
            return []
        }else{
            return JSON.parse(string)
        }
    }
})