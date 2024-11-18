<?php
namespace Routes;

use App\Models\UserModel;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

const NumPerPage = 10;
const GetAllQuery = "SELECT * from `products` WHERE 1 LIMIT ".NumPerPage." OFFSET ?";
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
        header("content-type: application/json");
        $out = "{}"; 
        $res->getBody()->write($out);
        return $res;
    }


    public function MyProducts(Request $request, Response $res)
    {
        header("content-type: application/json");
        $out = "{}"; 
        $res->getBody()->write($out);
        return $res;
    }


    public function Create(Request $request, Response $res)
    {
        $data = $request->getParsedBody();
        //$data = json_decode(file_get_contents("php://input"),true);
        $name = $data["name"] ?? null;
        $image = $data["image"] ?? null;
        $price = $data["price"] ?? null;
        $desc = $data["desc"] ?? null;
        $seller_id = $_SESSION["User"]['id'];
        $out = [];

        if(isset($name,$image,$price,$desc)){
            $stmt = DB->prepare(CreateQuery);
            $result =$stmt->execute([$name,$image,$price,$desc,$seller_id]);
            if($result){
                $out["message"] = "Created";
            }else{
                $out["message"] = "Failed To Create";
            }
        }else{
            $out["message"] = "Missing Param";
        }


        header("content-type: application/json");
        
        $res->getBody()->write(json_encode($out));
        return $res;
    }

    public function Update(Request $request, Response $res)
    {
        header("content-type: application/json");
        $out = "{}"; 
        $res->getBody()->write($out);
        return $res;
    }

    public function Delete(Request $request, Response $res)
    {
        header("content-type: application/json");
        $out = "{}"; 
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