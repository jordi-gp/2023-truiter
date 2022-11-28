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

        #TODO: Funció per obtindre tots els usuaris
        public function findUsers():array
        {
            $users = [];

            # Obtenció dels usuaris de la base de dades
            $stmt = $this->db->run("SELECT * FROM users");

            # Afegiment dels usuaris a l'array
            while($user = $stmt->fetch())
            {
                $userObj = new User($user["name"], $user["username"]);

                #$users[] =
            }

            return $users;
        }
    }
