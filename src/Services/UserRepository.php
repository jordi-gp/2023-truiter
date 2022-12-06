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
                #var_dump(DateTime::createFromFormat("Y-m-d h:i:s", $user["created_at"]));
                #$userObj->setCreatedAt(DateTime::createFromFormat("Y-m-d h:i:s", $user["created_at"]));

                $userObj->setCreatedAt(new DateTime());
                $users[] = $userObj;
            }

            return $users;
        }

        # Funció per trobar un usuari pel seu id
        public function findById(int $id):array|bool
        {
            $stmt = $this->db->run("SELECT * FROM user WHERE id=:id", ["id"=>$id]);
            return $stmt->fetch();
        }

        # Funció per eliminar l'usuari amb el seu id
        public function deleteUserById(int $userId)
        {
            $stmt = $this->db->run("DELETE FROM user WHERE id=:id", ["id"=>$userId]);
        }

        # Funció per trobar un usuari pel seu nom d'usuari
        public function findByUsername(string $username):array|bool
        {
            $stmt = $this->db->run("SELECT * FROM user WHERE username=:username", ["username"=>$username]);
            return $stmt->fetch();
        }

        # Funció per afegir un usuari a la base de dades
        public function save(User $user): void
        {
            $name = $user->getName();
            $username = $user->getUsername();
            $password = $user->getPassword();
            $created_at = $user->getCreatedAt()->format("Y-m-d H:i:s");
            $verified = 0;

            $stmt = $this->db->run("INSERT INTO user(name, username, password, created_at, verified)
                                        VALUES(:name, :username, :password, :created_at, :verified)",
                                        ["name"=>$name, "username"=>$username, "password"=>$password, "created_at"=>$created_at, "verified"=>$verified]);
            $lastId = (int) $this->db->getPDO()->lastInsertId();
            $user->setId($lastId);
        }

        # Funció per actualitzar el nom
        public function updateName(int $id, string $name)
        {
            $stmt = $this->db->run("UPDATE user SET name=:name WHERE id=:id", ["name"=>$name, "id"=>$id]);
        }

        # Funció per actualitzar el nom d'usuari
        public function updateUsername(int $id, string $username)
        {
            $stmt = $this->db->run("UPDATE user SET username=:username WHERE id=:id", ["username"=>$username, "id"=>$id]);
        }
    }
