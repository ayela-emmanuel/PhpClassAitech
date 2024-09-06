<?php
session_start();

const PROCUCTS = "products"; 
Init();

function Init() : void {
    if(!isset($_SESSION[PROCUCTS])){
        $_SESSION[PROCUCTS] = [];
    }
}
function AddProduct(string $name, string $desc) : bool {
    array_push($_SESSION[PROCUCTS], [
        "name"=> $name,
        "desc"=> $desc
    ]);
    return true;
}
function DeleteProduct(int $index = 0) : bool {
    array_splice($_SESSION[PROCUCTS], $index,1);
    return true;
}
function GetProducts(){
    return $_SESSION[PROCUCTS];
}
function Show(){
    $products = GetProducts();
    foreach ($products as $key => $value) {
        ?>
        <div class="product">
            <h3>
            <?php echo $value["name"] ?> 
            </h3>
            <div>
            <?php echo $value["desc"] ?> 
            <button onclick="delete_(<?php echo $key?> );">Delete</button>
            </div>
        </div>
        <?php
    }
}
?>

<script>


    
</script>
