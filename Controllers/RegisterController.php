<?php
namespace Controllers;
require "./DBConnect/index.php";
use Models\User;
use Models\Post;
use Auth\UserAuth;
use Hash;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Repositories\UserRepository;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Factory;
use Controllers\Validator\ValidatorFactory;

class RegisterController extends Controller{
    /**
     * @var UserRepository
     */
    protected $repository;
    
    protected $model;
    public function __construct(){
        $user = new User();
        $this->model = new UserRepository($user);
    }

    public function index()
    {
        return $this->model->all();
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     @OA\Response(response="200", description="Register route")
     * )
    */
    public function store(Request $request)
    {
        
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        $rules = [
            'name' => 'required|string',
            'email'=>'required|email',
            'password'=>'required'
        ];
        $validator = ValidatorFactory::Validator($request->all(), $rules, $messages);
        
        if ($validator->fails()){
			return json_encode(['error'=>$validator->errors()], 422);
        }
        try {
            $checkIfUserExist = User::where('email', $request->email)->first();
            if(!$checkIfUserExist){
                $pepper = "c1isvFdxMDdmjOlvxpecFw";
                $pwd_peppered = hash_hmac("sha256", $request->password, $pepper);
                $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
                $input = $request->except('0');
                $input['password'] = $pwd_hashed;
                $request = new \Illuminate\Http\Request($input);
                // dd($request);
                $user = $this->model->create($request->only($this->model->getModel()->fillable));

                return json_encode([
                    'status'=>true,
                    'message'=>'User created',
                    'data'   =>$user->toArray()
                ]);
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'User Already Exist'
                ]);
            }

        } catch (ValidatorException $e) {

            return json_encode([
                'error'   =>true,
                'message' =>$e->getMessage()
            ]);

        }
    }

    
}
?>  