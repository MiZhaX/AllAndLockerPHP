<?php

namespace Models;

class User
{

    protected static array $errores = [];

    public function __construct(
        private int|null $id,
        private string $nombre,
        private string $apellido,
        private string $email,
        private string $password,
        private string $role
    ) {}

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getErrores(): array
    {
        return self::$errores;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function validate(): bool
    {
        self::$errores = [];

        if (empty($this->nombre)) {
            self::$errores['nombre'] = 'El nombre es obligatorio.';
        }

        if (empty($this->apellido)) {
            self::$errores['apellido'] = 'El apellido es obligatorio.';
        }

        if (empty($this->email)) {
            self::$errores['email'] = 'El email es obligatorio.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$errores['email'] = 'El email no es válido.';
        }

        if (empty($this->password)) {
            self::$errores['password'] = 'La contraseña es obligatoria.';
        } elseif (strlen($this->password) < 6) {
            self::$errores['password'] = 'La contraseña debe tener al menos 6 caracteres.';
        }

        return empty(self::$errores);
    }

    public function sanitize(): void
    {
        $this->nombre = filter_var($this->nombre, FILTER_SANITIZE_STRING);
        $this->apellido = filter_var($this->apellido, FILTER_SANITIZE_STRING);
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        $this->password = filter_var($this->password, FILTER_SANITIZE_STRING);
        $this->role = filter_var($this->role, FILTER_SANITIZE_STRING);
    }

    public static function fromArray(array $data): User
    {
        return new User(
            id: $data['id'] ?? null,
            nombre: $data['nombre'] ?? '',
            apellido: $data['apellidos'] ?? '',
            email: $data['email'] ?? '',
            password: $data['password'] ?? '',
            role: $data['rol'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
        ];
    }
}
