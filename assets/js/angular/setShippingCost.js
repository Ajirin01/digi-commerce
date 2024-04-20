myApp.filter('setShippingCost', function(){
    return (lga, state) => {
        if(lga == undefined){
            return 0
        }else{
            let cost_1000 = [
                'Bosso',
                'Chanchaga',
                'Gurara',
                'Rafi',
                'Shiroro'
            ]

            let cost_1500 = [
                "Bida",
                "Lapai",
                "Mokwa",
                "Suleja",
                "Wushishi"
            ]

            if(cost_1000.includes(lga)){
                return 1000
            }else if(cost_1500.includes(lga)){
                return 1500
            }
            else if(state == "niger" && !(cost_1000.includes(lga) || cost_300.includes(lga))){
                return 2000
            }else if(state == "abuja" || state == "nasarawa" || state == "kano" || state == "zamfara" || state == "bauchi" || state == "kaduna" || state == "pleatue"){
                return 5000
            }else{
                return 6000
            }
        }
    }
})