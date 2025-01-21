<?php
class Server {
    public function serve() {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if ($uri == "/practica-3-ws/API/getToken/" && $method == "GET") {
            $token = $this->getToken();
            header('HTTP/1.1 200');
            header('Content-type: application/json');
            echo json_encode(array("token" => $token));
        }
    }
    public function getToken() {
        $mayus = chr(rand(65, 90)) . chr(rand(65, 90));
        $minus = chr(rand(97, 122)) . chr(rand(97, 122));
        $numeros = rand(1000, 9999);
        $especial = chr(rand(33, 47));
        return $mayus . $minus . $numeros . $especial;
    }
}
$server = new Server();
$server->serve();
