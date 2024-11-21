<?php
namespace Routes;

use App\Models\UserModel;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Http\UploadedFile;


const NumPerPage = 10;
const GetAllQuery = "SELECT * from `products` WHERE 1 LIMIT ".NumPerPage." OFFSET ?";
const GetByUserIdQuery = "SELECT * from `products` WHERE `seller_id` = ? LIMIT ".NumPerPage." OFFSET ?";
const GetByIdQuery = "SELECT * from `products` WHERE `id` = ? ";
const DeleteByIdQuery = "DELETE from `products` WHERE `id` = ? ";
const UpdateQuery = "UPDATE `products` SET `name` = ?, `image` = ?, `price` = ?, `desc` = ?";
const CreateQuery = "INSERT INTO `products` (`name`,`image`,`price`,`desc`,`seller_id`) VALUES (?,?,?,?,?)";



class ProductsController{

    protected $container;
    // constructor receives container instance
   public function __construct($container) {
       $this->container = $container;
   }

    public UserModel $user;

    public function GetById(Request $request, Response $res)
    {
        $data = $request->getQueryParams();
        $id = $data['id'] ?? null;
        $out = "{}";
        if($id){
            $stmt = DB->prepare(GetByIdQuery);
            $stmt->execute([$id]);
            $result = $stmt->get_result();
            if($result->num_rows){
                $data = $result->fetch_assoc();
                $out = json_encode($data);
            }
        }
        $res->getBody()->write($out);
        header("content-type: application/json");
        return $res;
    }

    public function GetAll(Request $request, Response $res)
    {
        $page = $_GET["page"] ?? 1;
        $offset = ($page - 1) * NumPerPage;
        $stmt = DB->prepare(GetAllQuery);
        $out = "[]";
        if($stmt->execute([$offset])){
            $request = $stmt->get_result();
            $data = $request->fetch_all(MYSQLI_ASSOC);
            $out = json_encode($data);
        }
        header("content-type: application/json");
        $res->getBody()->write($out);
        return $res;
    }


    public function MyProducts(Request $request, Response $res)
    {
        $page = $_GET["page"] ?? 1;
        $offset = ($page - 1) * NumPerPage;
        $stmt = DB->prepare(GetByUserIdQuery);
        $out = "[]";
        $sid = $_SESSION["User"]['id'];
        if($stmt->execute([$_SESSION["User"]['id'],$offset])){
            $request = $stmt->get_result();
            $data = $request->fetch_all(MYSQLI_ASSOC);
            $out = json_encode($data);
        }
        header("content-type: application/json");
        $res->getBody()->write($out);
        return $res;
    }


    public function Create(Request $request, Response $res)
    {
        $uploadDir = __DIR__."/../static/uploads";
        $data = $request->getParsedBody();
        //$data = json_decode(file_get_contents("php://input"),true);
        $name = $data["name"] ?? null;
        //$image = $data["image"] ?? null;
        $image = $_FILES["image"]??null;
        $price = $data["price"] ?? null;
        $desc = $data["desc"] ?? null;
        $seller_id = $_SESSION["User"]['id'];
        $out = [];

        if ($image["error"] == 0) {
            $image_name = uniqid("FILE_").".".pathinfo( $image["name"], PATHINFO_EXTENSION);
            //FILE_3456789dsf.png

            $result = move_uploaded_file($image["tmp_name"],$uploadDir. "/" . $image_name );
            if($result){
                if(isset($name,$image,$price,$desc)){
                    $stmt = DB->prepare(CreateQuery);
                    $result =$stmt->execute([$name,"/static/uploads/".$image_name,$price,$desc,$seller_id]);
                    if($result){
                        $out["message"] = "Created";
                    }else{
                        $out["message"] = "Failed To Create";
                    }
                }else{
                    $out["message"] = "Missing Param";
                }
            }else{
                $out["message"] = "Failed To Process Uploaded File";
            }
            
        }else{
            $out["message"] = "Failed To Upload";
        }

        header("content-type: application/json");
        
        $res->getBody()->write(json_encode($out));
        return $res;
    }

    public function Update(Request $request, Response $res)
    {
        $uploadDir = __DIR__."/../static/uploads";

        $name = $_POST["name"] ?? null;
        $image = $_FILES["image"]??null;
        $price = $_POST["price"] ?? null;
        $desc = $_POST["desc"] ?? null;

        if($image != null){
            $image_name = uniqid("FILE_").".".pathinfo( $image["name"], PATHINFO_EXTENSION);
            //FILE_3456789dsf.png
            $result = move_uploaded_file($image["tmp_name"],$uploadDir. "/" . $image_name );
            $stmt = DB->prepare("UPDATE `products` SET `image` = ?");
            $stmt->execute([$image_name]);
        }

        if($name != null){
            $stmt = DB->prepare("UPDATE `products` SET `name` = ?");
            $stmt->execute([$name]);
        }

        if($price != null && filter_var($price,FILTER_SANITIZE_NUMBER_FLOAT)){
            $stmt = DB->prepare("UPDATE `products` SET `price` = ?");
            $stmt->execute([$price]);
        }

        if($desc != null){
            $stmt = DB->prepare("UPDATE `products` SET `desc` = ?");
            $stmt->execute([$desc]);
        }

        header("content-type: application/json");
        $out = "{}"; 
        $res->getBody()->write($out);
        return $res;
    }

    public function Delete(Request $request, Response $res)
    {
        $product_id = $_GET["id"]??null;
        $stmt = DB->prepare(DeleteByIdQuery);
        $out = "{}";
        if(!$product_id){
            header("content-type: application/json");
            $res->getBody()->write($out);
            return $res;
        }
        $stmt->execute([$product_id]);
        header("content-type: application/json");
        $res->getBody()->write($out);
        return $res;
    }

    public function AddToCart(Request $request, Response $res)
    {
        header("content-type: application/json");
        $out = "{}"; 
        $res->getBody()->write($out);
        return $res;
    }


    
}




?>