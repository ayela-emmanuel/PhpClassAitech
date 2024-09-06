


function delete_(index){

    fetch("/api/delete.php?index="+index)
    .then((r)=>{
        if(r.status == 200){
            var elements = document.getElementsByClassName("product");
            if(elements[0]){
                elements[0].parentNode.removeChild(elements[index])
            }
        }
    });
    
}


function login(){
    var data = {
        "username":"emmanuel", 
        "password": "aaaaaa"
    }
    
    fetch("/api/login.php", {
        method : "POST",
        body : JSON.stringify(data)
    }).then((r)=>{
        return r.text()
    }).then((data)=>{
        console.log(data)
    })
}