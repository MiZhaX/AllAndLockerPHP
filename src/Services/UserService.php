<?php 
namespace Services;
use Repositories\UserRepository;
use Models\User;

class UserService{
    private UserRepository $userRepository;
    private User $user;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    // Guardar usuario
    public function save(User $user){
        $this->userRepository->save($user);
    }

    // Obtener un usuario por su correo
    public function getUserByEmail(string $email):User|bool {
        return $this->userRepository->getUserByEmail($email);
    }
}
?>