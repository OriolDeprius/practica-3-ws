<?php

require_once 'BdD.php';

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
        $api_key = urldecode($api_key);

        if ($resource == "GetToken" && $method == "GET") {
            if ($api_key == "Pràctica-WS") {
                $token = $this->createToken();
                header('HTTP/1.1 200');
                header('Content-type: application/json');
                echo json_encode(array("token" => $token));
            } else {
                header('HTTP/1.1 401');
                header('Content-type: application/json');
                echo json_encode(array("error" => "Unauthorized"));
            }
        } else if ($resource == "Activitats") {
            $headers = apache_request_headers();
            $tokenValidat = $this->validarToken();
            // echo $headers['X-Authorization'];
            if (isset($headers['X-Authorization']) and $tokenValidat) {
                $bd = new BdD();
                $respostaBD = $bd->getTotesLesOfertes();
                header('HTTP/1.1 200');
                header('Content-type: application/json');
                echo json_encode($respostaBD);
            } else {
                header('HTTP/1.1 401');
                header('Content-type: application/json');
                echo json_encode(array("error" => "Unauthorized"));
            }
        } else if ($resource == "Test") {
            $temps = time();
            $headers = apache_request_headers();
            $match = false;
            if (isset($headers)) {
                $token = $headers['X-Authorization'];
                while ($temps < time() + 60000 and !$match) {
                }
            }
        }
    }
    /**
     * getToken
     * Genera un token aleatori
     * @return String
     */
    public function createToken() {
        $numMayus = rand(2, 5);
        $numMinus = rand(2, 5);
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
        return $token;
    }
    /**
     * validarToken
     * true si el token es vàlid, false si no ho és
     * @return Boolean 
     */
    public function validarToken() {
        $headers = apache_request_headers();
        if (isset($headers['X-Authorization'])) {
            $token = $headers['X-Authorization'];
            $numMayus = preg_match_all('/[A-Z]/', $token);
            $numMinus = preg_match_all('/[a-z]/', $token);
            $numNum = preg_match_all('/[0-9]/', $token);
            $numEspecial = preg_match_all('/[\W_]/', $token);

            if ($numMayus >= 2 && $numMinus >= 2 && $numNum >= 4 && $numEspecial >= 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
$server = new Server();
$server->serve();
