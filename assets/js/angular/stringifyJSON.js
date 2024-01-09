myApp.filter('stringifyJSON', function(){
    return (obj) => {
        if(obj == undefined){
            return null
        }else{
            return JSON.stringify(obj)
        }
    }
})