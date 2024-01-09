myApp.filter('setShippingCost', function(){
    return (lga, state) => {
        if(lga == undefined){
            return 0
        }else{
            let cost_300 = [
                'Bosso',
                'Chanchaga',
                'Gurara',
                'Rafi',
                'Shiroro'
            ]

            let cost_1000 = [
                "Bida",
                "Lapai",
                "Mokwa",
                "Suleja",
                "Wushishi"
            ]

            if(cost_300.includes(lga)){
                return 300
            }else if(cost_1000.includes(lga)){
                return 1000
            }else if(state == "niger" && !(cost_1000.includes(lga) || cost_300.includes(lga))){
                return 1500
            }else if(state == "abuja" || state == "nasarawa" || state == "kano" || state == "zamfara" || state == "bauchi" || state == "kaduna" || state == "pleatue"){
                return 2000
            }else{
                return 3000
            }
        }
    }
})