<?php

namespace Models;

class OrderLine
{
    protected static array $errores = [];

    public function __construct(
        private int|null $id,
        private int $pedido_id,
        private int $producto_id,
        private int $unidades
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

    public function getPedidoId()
    {
        return $this->pedido_id;
    }

    public function setPedidoId($pedido_id)
    {
        $this->pedido_id = $pedido_id;

        return $this;
    }

    public function getProductoId()
    {
        return $this->producto_id;
    }

    public function setProductoId($producto_id)
    {
        $this->producto_id = $producto_id;

        return $this;
    }

    public function getUnidades()
    {
        return $this->unidades;
    }

    public function setUnidades($unidades)
    {
        $this->unidades = $unidades;

        return $this;
    }

    public function getErrores(): array
    {
        return self::$errores;
    }

    public function validate(): bool
    {
        return true;
    }

    public function sanitize(): void
    {
        $this->pedido_id = filter_var($this->pedido_id, FILTER_SANITIZE_NUMBER_INT);
        $this->producto_id = filter_var($this->producto_id, FILTER_SANITIZE_NUMBER_INT);
        $this->unidades = filter_var($this->unidades, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function fromArray(array $data): OrderLine
    {
        return new OrderLine(
            (int)$data['id'] ?? null,
            (int)$data['pedido_id'] ?? null,
            (int)$data['producto_id'] ?? null,
            (int)$data['unidades'] ?? 0
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'pedido_id' => $this->pedido_id,
            'producto_id' => $this->producto_id,
            'unidades' => $this->unidades,
        ];
    }
}