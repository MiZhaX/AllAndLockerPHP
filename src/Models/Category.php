<?php

namespace Models;

class Category
{
    protected static array $errores = [];

    public function __construct(
        private int|null $id,
        private string $name
    ) {}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public static function getErrores():array {
        return self::$errores;
    }

    public function validate():bool {
        self::$errores = [];
        
        if (trim($this->name) == '') {
            self::$errores['name'] = 'El nombre de la categoría no puede estar vacío o contener solo espacios';
        }
        return empty(self::$errores);
    }

    public function sanitize():void {
        $this->name = filter_var($this->name, FILTER_SANITIZE_STRING);
    }

    public static function fromArray(array $data):Category {
        return new Category(
            $data['id'] ?? null,
            $data['name'] ?? ''
        );
    }
}
