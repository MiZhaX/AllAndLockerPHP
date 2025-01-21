<?php

namespace Models;

class Product
{

    protected static array $errores = [];

    public function __construct(
        private int|null $id,
        private int|null $category_id,
        private string $name,
        private string $description,
        private float $price,
        private int $stock,
        private string $oferta,
        private string $date,
        private string $image
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

    public function getCategory_id()
    {
        return $this->category_id;
    }

    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    public function getOferta()
    {
        return $this->oferta;
    }

    public function setOferta($oferta)
    {
        $this->oferta = $oferta;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getErrores(): array
    {
        return self::$errores;
    }

    public function validate(): bool
    {
        self::$errores = [];

        if (empty(trim($this->name))) {
            self::$errores['nombre'] = 'El nombre del producto es obligatorio';
        }

        if (empty(trim($this->description))) {
            self::$errores['descripcion'] = 'La descripción del producto es obligatoria';
        }

        if ($this->price <= 0) {
            self::$errores['precio'] = 'El precio debe ser mayor a 0';
        }

        if (empty($this->stock) || $this->stock < 0) {
            self::$errores['stock'] = 'El stock no puede ser negativo';
        }

        if (isset($this->oferta) && $this->oferta != '') {
            if($this->oferta < 0 || $this->oferta > 100) {
                self::$errores['oferta'] = 'La oferta no es válida';
            }
        }

        if (empty($this->category_id)) {
            self::$errores['categoria_id'] = 'La categoría del producto es obligatoria';
        }

        return empty(self::$errores);
    }

    public function sanitize():void{
        $this->name = filter_var($this->name, FILTER_SANITIZE_STRING);
        $this->description = filter_var($this->description, FILTER_SANITIZE_STRING);
        $this->price = filter_var($this->price, FILTER_SANITIZE_NUMBER_FLOAT);
        $this->stock = filter_var($this->stock, FILTER_SANITIZE_NUMBER_INT);
        $this->oferta = filter_var($this->oferta, FILTER_SANITIZE_STRING);
        $this->date = filter_var($this->date, FILTER_SANITIZE_STRING);
        $this->image = filter_var($this->image, FILTER_SANITIZE_STRING);
    }

    public static function fromArray(array $data): Product
    {
        return new Product(
            (int)$data['id'] ?? null,
            (int)$data['categoria_id'] ?? null,
            $data['nombre'] ?? '',
            $data['descripcion'] ?? '',
            (float)$data['precio'] ?? '',
            (int)$data['stock'] ?? '',
            $data['oferta'] ?? '',
            date('Y-m-d'),
            $data['imagen'] ?? ''
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'categoria_id' => $this->category_id,
            'nombre' => $this->name,
            'descripcion' => $this->description,
            'precio' => $this->price,
            'stock' => $this->stock,
            'oferta' => $this->oferta,
            'fecha' => $this->date,
            'imagen' => $this->image,
        ];
    }
}
