<?php
/**
 * Classe Server
 * S'encarrega de servir la petició
 */
class Server {    
    /**
     * serve
     * Funció que s'encarrega de servir la petició
     * @return Void
     */
    public function serve() {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $paths = explode("/", $uri);
        array_shift($paths);
        array_shift($paths);
        array_shift($paths);
        $resource = array_shift($paths);
        $api_key = array_shift($paths);
        $tokenGenerat = "";

        if ($resource == "GetToken" && $method == "GET") {
            if ($api_key == "Pr%C3%A0ctica-WS"){
                $token = $this->createToken();
                header('HTTP/1.1 200');
                header('Content-type: application/json');
                echo json_encode(array("token" => $token));
            }
            else {
                header('HTTP/1.1 401');
                header('Content-type: application/json');
                echo json_encode(array("error" => "Unauthorized"));
            }
        }

        if($resource == "Activitats"){
            $headers = apache_request_headers();
            echo json_encode($headers['X-Authorization']);
            echo json_encode($tokenGenerat);
            /* if($headers['X-Authorization'] == $tokenGenerat){
                $bd = new BdD();
                $respostaBD = $bd->getTotesLesOfertes();
                header('HTTP/1.1 200');
                header('Content-type: application/json');
                echo json_encode($respostaBD);
            }
            else{
                header('HTTP/1.1 401');
                header('Content-type: application/json');
                echo json_encode(array("error" => "Unauthorized"));
            } */
        }

    }    
    /**
     * getToken
     * Genera un token aleatori
     * @return String
     */
    public function createToken() {
        $numMayus = rand(2, 5);
        $numMinus= rand(2, 5);
        $numNum = rand(2, 5);
        $numEspecial = rand(2, 5);
        $token = "";

        for ($i = 0; $i < $numMayus; $i++) {
            $mayus = chr(rand(65, 90));
            $token .= $mayus;
        }
        for ($i = 0; $i < $numMinus; $i++) {
            $minus = chr(rand(97, 122));
            $token .= $minus;
        }
        for ($i = 0; $i < $numNum; $i++) {
            $numeros = rand(1000, 9999);
            $token .= $numeros;
        }
        for ($i = 0; $i < $numEspecial; $i++) {
            $especial = chr(rand(33, 47));
            $token .= $especial;
        }
        
        $token = str_shuffle($token);
        $tokenGenerat = $token;
        return $token; 
    }
}
$server = new Server();
$server->serve();
