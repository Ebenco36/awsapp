<?php
    namespace Routes;
    require "./vendor/autoload.php";

    use Controllers\APIController;
    use Controllers\LoginController;
    use Controllers\RegisterController;
    use Auth\UserAuth;

    class Router extends UserAuth
    {

        public static function run(){
            /**
             * ROUTE MANAGEMENT
             */
            $jwt_token = '';
            // Exclude these endpoint from the HTTP_AUTHORIZATION condition below
            $exclude = isset($_SERVER['PATH_INFO']) ? in_array($_SERVER['PATH_INFO'], ['/login', '/register']) : false;
            if(!$exclude){
                if (!isset($_SERVER['HTTP_AUTHORIZATION']) || ! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
                    header('HTTP/1.0 400 Bad Request');
                    echo 'Token not found in request';
                    exit;
                    
                }else{
                    $jwt_token = $matches[1];
                }
            }

            $res = json_decode(parent::UserMiddleware($jwt_token));
            
            $router = new \Klein\Klein();
            $requests = new \Illuminate\Http\Request();
            if($res->status){
                //Respond to all API request. Pathway to all request
                $router->with('/api/v1', function () use ($router) {
                    $router->respond(function ($request) {
                        $resp = new APIController();
                        $path = $request->pathname();
                        if($path == '/api/v1/people'){
                            return $resp->people();
                        }elseif($path == '/api/v1/ticket_purchase_history'){
                            return $resp->Ticket_purchase_history();
                        }else{
                            // Handle Routes that does not exist.
                            return json_encode(['status' => false, 'message' => $path.' doesn\'t exist']);
                        }
                    });
                });
            }else{
                // Return error message for invalid token
                if(!$exclude){
                    $router->respond(function ($request) {
                        return json_encode(['status' => false, 'message' => 'Not a valid token']);
                    });
                }
            }

            
            // Login Route
            $router->respond('POST', '/login', function ($request, $response) use($requests) {
                $requests->replace($request->params());
                $resp = new LoginController();
                return $resp->login($requests);
            
            });

            // Register Route
            $router->respond('POST', '/register', function ($request, $response)use($requests) {
                $requests->replace($request->params());
                // dd($requests);
                $resp = new RegisterController();
                return $resp->store($requests);
            
            });

            // I guess you cannot find your page?
            $router->respond(function ($request) {
                $path = $request->params();
                // dd($path);
                if(isset($path[0]) && $path[0] != "/login" && $path[0] != "/register" && $path[0] != "/api" && $path[0] != "/api/v1" && $path[0] != "/api/v1/"){
                    return json_encode(['status' => false, 'message' => 'Page not found right?']);
                }
            });
            $router->dispatch();


        }
    }
