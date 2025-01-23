<?php

/**
 * Classe BdD
 * Gestiona la base de dades
 */
class BdD {
    /**
     * @var Array configuracio de la base de dades
     */
    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    /**
     * @var PDO connexió base de dades
     */
    public static $connection;

    /**
     * db_host
     *
     * @var String
     */
    private $db_host;
    /**
     * db_user
     *
     * @var String
     */
    private $db_user;
    /**
     * db_password
     *
     * @var String
     */
    private $db_password;
    /**
     * db_db
     *
     * @var String
     */
    private $db_db;

    /**
     * __construct
     * Constructor de la classe
     * @return Void
     */
    public function __construct() {
        $this->db_host = 'localhost';
        $this->db_user = 'root';
        $this->db_password = 'root';
        $this->db_db = 'ganga';

        $this->connect($this->db_host, $this->db_user, $this->db_password, $this->db_db);
    }

    /**
     * __destruct
     *  Destructor de la classe
     * @return Void
     */
    public function __destruct() {
        self::$connection = null;
    }

    /**
     * connect
     * Funció que connecta a la base de dades
     *
     * @param  String $db_host
     * @param  String $db_user
     * @param  String $db_password
     * @param  String $db_db
     * @return Void
     */
    public static function connect($db_host, $db_user, $db_password, $db_db) {
        if (!isset(self::$connection)) {
            self::$connection = @new PDO(
                "mysql:host=$db_host;dbname=$db_db",
                $db_user,
                $db_password,
                self::$settings
            );
        }
    }

    /**
     * getTotesLesOfertes
     *  Funció que retorna totes les ofertes
     * @return Array
     */
    public function getTotesLesOfertes() {
        $sql = "SELECT * FROM ofertes";
        $query = self::$connection->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
