myApp.filter('number', function(){
    return (string, index) => {
        if(string == undefined){
            return 0
        }else{
            return Number(JSON.parse(string)[index])
        }
    }
})