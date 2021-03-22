<?php
namespace Controllers;

require "./DBConnect/index.php";
use Models\User;
use Models\Post;
use Auth\UserAuth;
use Hash;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Factory;
use Controllers\Validator\ValidatorFactory;

class LoginController extends Controller{

    /**
     * @OA\Post(
     *     path="/login",
     *     @OA\Response(response="200", description="Login route")
     * )
    */
    public function login(Request $request){

        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        $rules = [
            'email'=>'required|email',
            'password'=>'required'
        ];
        $validator = ValidatorFactory::Validator($request->all(), $rules, $messages);
        
        if ($validator->fails()){
            return json_encode(['error'=>$validator->errors()], 422);
        }
        $pepper = "c1isvFdxMDdmjOlvxpecFw";
        $pwd = $request->password;
        $pwd_peppered = hash_hmac("sha256", $pwd, $pepper);
        // create a class instance
        $auth = new UserAuth();
        
        $token = $auth->SendUserToken($request->email, $pwd_peppered);
        return json_encode($token);
    }
}
?>  