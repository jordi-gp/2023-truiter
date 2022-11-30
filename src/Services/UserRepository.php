<?php declare(strict_types=1);

    namespace App\Services;

    use App\Registry;
    use App\User;
    Use DateTime;

    class UserRepository
    {
        private DB $db;

        public function __construct()
        {
            $this->db = Registry::get(Registry::DB);
        }

        # Funció per trobar tots els usuaris
        public function findAll():array
        {
            $users = [];

            # Obtenció dels usuaris de la base de dades
            $stmt = $this->db->run("SELECT * FROM user");

            # Afegiment dels usuaris a l'array
            while($user = $stmt->fetch())
            {
                $userObj = new User($user["name"], $user["username"]);
                $users[] = $userObj;
            }

            return $users;
        }

        # Funció per trobar un usuari per el seu id
        public function findById(int $id):array|bool
        {
            $stmt = $this->db->run("SELECT * FROM user WHERE id=:id", ["id"=>$id]);
            return $stmt->fetch();
        }

        # Funció per trobar un usuari per el seu nom d'usuari
        public function findByUsername(string $username):array|bool
        {
            $stmt = $this->db->run("SELECT * FROM user WHERE username=:username", ["username"=>$username]);
            return $stmt->fetch();
        }
    }
