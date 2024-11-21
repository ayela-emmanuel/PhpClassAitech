

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
        PopulateProducts("products_container_seller","/api/products/my",1 , true)
    })

}
function GenerateProductCard(image, title, desc, price, id, isAdmin = false){
    var btns = isAdmin ? 
    `
    <div>
        <button onclick="DeleteProduct(${id})">Delete</button>
        <button>Update</button>
    </div>
    `
    : 
    `
        <div>
            <button>Add To Cart</button>
            <button>Buy Now</button>
        </div>
    `
    
    var product_card_template = `
        <div class="product-card">
            <img src="${image ?? "/static/images/product.avif" }" alt="">
            <h4>${title}</h4>
            <p>${desc}</p>
            <p>${Number(price).toLocaleString(undefined, {minimumFractionDigits:2})} NGN</p>
            ${btns}
        </div>`;
        
    return product_card_template;
}



function DeleteProduct(id){
    fetch("/api/products/delete?id="+id,{
        method: "DELETE"
    })
    PopulateProducts("products_container_seller","/api/products/my",1 , true)

}

function PopulateProducts(containerId, url = "/api/products/all", page = 1, isAdmin = false){
    var container = document.getElementById(containerId);
    if(!container){
        return;
    }
    fetch(`${url}?page=${page}`)
    .then((response)=>{
        return response.json();
    }).then((data)=>{
        container.innerHTML = ""
        data.forEach(product => {
           container.innerHTML +=  GenerateProductCard(product.image, product.name,product.desc,product.price,product.id, isAdmin);
        });
    })
}
PopulateProducts("products_container")
PopulateProducts("products_container_seller","/api/products/my",1 , true)