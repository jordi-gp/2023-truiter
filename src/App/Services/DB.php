<?php
    namespace App;
    
    # Classe per instanciar la base de dades
    class DB
    {
        public $pdo;

        public function __construct(string $db, $username=null, string $password=null, string $host='127.0.0.1', int $port=3306, array $options = [])
        {
            $default_options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            $options = array_replace($default_options, $options);
            $dsn = 'mysql:host='.$host.';dbname='.$db.';port='.$port.';charset=utf8mb4';

            try {
                $this->pdo = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $err) {
                throw new PDOException($err->getMessage(), (int)$err->getCode());
            }
        }

        # Funció per executar consultes
        public function run(string $sql, $args = null)
        {
            if(!$args) {
                return $this->pdo->query($sql);
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt;
        }
    }