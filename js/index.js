getAmoutOfGoodsInCart()

function getAmoutOfGoodsInCart(){
    let storageData1 = localStorage.getItem('webshopCart')

    amountCart.innerHTML = storageData1 ? `(${Object.keys(JSON.parse(localStorage.getItem('webshopCart'))).length})` : "" 
}

function addToCart(amount, productID, productIMG, price, productname){
    let shoppingCartLocal = JSON.parse(localStorage.getItem('webshopCart'))
    let newLocalStorageObj = {}
    
    if(shoppingCartLocal != null && shoppingCartLocal.hasOwnProperty(productID)){
        let totalAmount = amount + shoppingCartLocal[productID][0]
        let newArray = shoppingCartLocal[productID].slice(1)
        newArray.unshift(totalAmount)
        
        newLocalStorageObj = {
                    ...shoppingCartLocal,
                     [productID]: newArray
                }
    } else {
        newLocalStorageObj = {
            ...shoppingCartLocal,
            [productID]: [amount, productIMG, price, productname]
        }
    }

    localStorage.setItem('webshopCart', JSON.stringify(newLocalStorageObj))
    getAmoutOfGoodsInCart()
}

const detailAddCartInput = document.getElementById('detailAddCartInput')
if(detailAddCartInput!= null){

    detailAddCartInput.addEventListener('input',(e) => {

        e.target.value = e.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')
        
        if(e.target.value > 100){
            e.target.value = "100"
        } else if(e.target.value == ""){
            e.target.value = "1"
        }
        
        
    })
}

function checkInput(e) {
    console.log(e)
    e.value = e.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')
        
        if(e.value > 100){
            e.value = "100"
        } else if(e.value == ""){
            e.value = "1"
        }
}


const detailAddCart = document.getElementById('detailAddCart')

if(detailAddCart!=null){
    detailAddCart.addEventListener('click', ()=> {
        addToCart(parseInt(detailAddCartInput.value), detailAddCart.dataset.id, detailAddCart.dataset.picture, detailAddCart.dataset.price, detailAddCart.dataset.name)
        getAmoutOfGoodsInCart()
    })

}

const shoppinCartTableInput = document.getElementById('shoppingCartTable')

$(document).ready(function (){
    let storageData = localStorage.getItem('webshopCart')

    $.post(
        'ajax/getTable.php',
        {webshop: storageData},
        function(phpdata){
            if(shoppinCartTableInput != null) {

                shoppingCartTable.innerHTML = phpdata
            }
        }
    )
    
    getAmoutOfGoodsInCart()

})

function deleteProduct(deletID){

    let storageData = JSON.parse(localStorage.getItem('webshopCart'))
    delete storageData[deletID]
    ajaxCall(storageData)
    
    localStorage.setItem('webshopCart',JSON.stringify(storageData))
    if(Object.keys(storageData).length == 0){
        localStorage.removeItem('webshopCart')
        ajaxCall(null)
    }
    getAmoutOfGoodsInCart()
}



function updateCart(event, productID) {
    let newValue = event.parentElement.firstChild.value
    let storageData = JSON.parse(localStorage.getItem('webshopCart'))
    storageData[productID][0]=newValue

    ajaxCall(storageData)

    
    localStorage.setItem('webshopCart',JSON.stringify(storageData))
    getAmoutOfGoodsInCart()

}

function clearCart() {
    localStorage.removeItem('webshopCart')
    ajaxCall(null)
}

function ajaxCall(localStorageData){
    $.post(
        'ajax/getTable.php',
        {webshop: JSON.stringify(localStorageData)},
        function(phpdata){
            if(shoppingCartTable != null){

                shoppingCartTable.innerHTML = phpdata
            }
        }
    )
}

