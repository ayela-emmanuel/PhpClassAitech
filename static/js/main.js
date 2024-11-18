

function CreateProduct(){
    var form =  document.querySelector("#create-product-id")

    var product = new FormData(form);

    fetch("/api/products/create",{
        method:"POST",
        body: product
    }).then((response)=>{
        return response.json();
    })
    .then((data)=>{
        alert(data.message)
        form.clear()
    })
    

}