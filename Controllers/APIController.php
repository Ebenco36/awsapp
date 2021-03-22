<?php
namespace Controllers;
/**
 * @OA\Info(title="AWSAPP", version="1.0")
 */
require "./DBConnect/index.php";
use Models\User;
use Models\Person;
use Models\Ticket_purchase_history;
use \Illuminate\pagination\Paginator;
use Illuminate\Database\Capsule\Manager as DB;
class APIController extends Controller {
    
    /**
     * @OA\Get(
     *     path="/api/v1/people",
     *     @OA\Response(response="200", description="Get paginated record of people")
     * )
    */
    public function People(){
        $data = Person::paginate(50);
        return json_encode(['data' => $data], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/ticket_purchase_history",
     *     @OA\Response(response="200", description="Get paginated records of purchases")
     * )
    */
    public function Ticket_purchase_history(){
        $data = Ticket_purchase_history::paginate(50);
        return json_encode(['data' => $data], 200);
    }




}

?>  