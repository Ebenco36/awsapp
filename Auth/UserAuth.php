<?php
    namespace Auth;
    require_once 'vendor/autoload.php';
    use \Firebase\JWT\JWT;
    use DB;
    use Models\User;
    class UserAuth {
          // create an empty id variable to hold the user id
        private $id;
        // key for JWT signing and validation, shouldn't be changed
        private $key = "secretSignKey";


        // Checks if the user exists in the database
        private function validUser($email, $password) {
        // doing a user exists check with minimal to no validation on user input
        $ValidUser = User::where('email', $email)->first();
        if ($ValidUser && password_verify($password, $ValidUser->password)) {
            // Add user email and id to empty email and id variable and return true
            $this->id = $ValidUser->id;
            
            $this->email = $ValidUser->email;
            
            return json_encode(['status'=> true, 'user'=>$ValidUser]);
        } else {
            
          return json_encode(['status'=> false, 'user'=>$ValidUser]);
        }
        }

        private function genJWT() {
            // Make an array for the JWT Payload
            $payload = array(
              "id" => $this->id,
              "email" => $this->email,
              "exp" => time() + (60 * 60)
            );
           
            // encode the payload using our secretkey and return the token
            return JWT::encode($payload, $this->key);
        
        
        }


        // sends signed token in email to user if the user exists
        public function SendUserToken($email, $password) {
              // check if the user exists
              $checkout = $this->validUser($email, $password);
              $data = json_decode($checkout);
              
              if ($data->status) {
                  // generate JSON web token and store as variable
                  $token = $this->genJWT();
                  
                  return ['token'=> $token, 'user'=> $data->user];
              }else{
                  return $this->validUser($email, $password);
              }
            
        }

        private function validJWT($token) {
            $res = array(false, '');
            // using a try and catch to verify
            try {
              //$decoded = JWT::decode($token, $this->key, array('HS256'));
              $decoded = JWT::decode($token, $this->key, array('HS256'));
            } catch (Exception $e) {
              return $res;
            }
            $res['0'] = true;
            $res['1'] = (array) $decoded;
         
            return $res;
        }
         
         
          public function UserMiddleware($token) {
            $res = array(false, '');
            // using a try and catch to verify
            try {
              //$decoded = JWT::decode($token, $this->key, array('HS256'));
              $decoded = JWT::decode($token, 'secretSignKey', array('HS256'));
            } catch (Exception $e) {
              return json_encode(['status' => false,'error' => $e->getMessage()]);
            }
            catch (\Firebase\JWT\ExpiredException $e) {
              return json_encode(['status' => false,'error' => $e->getMessage()]);
            }
            catch (\UnexpectedValueException $e) {
              return json_encode(['status' => false,'error' => $e->getMessage()]);
            }
            catch (\InvalidArgumentException $e) {
              return json_encode(['status' => false,'error' => $e->getMessage()]);
            }
            catch (\DomainException $e) {
              return json_encode(['status' => false,'error' => $e->getMessage()]);
            }
            catch (\Firebase\JWT\SignatureInvalidException $e) {
              return json_encode(['status' => false,'error' => $e->getMessage()]);
            }
            $res['status'] = true;
            $res['data'] = (array) $decoded;
         
            return json_encode($res);
    }
}