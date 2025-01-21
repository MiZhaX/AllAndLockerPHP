<?php

namespace Models;

class Order
{
    protected static array $errores = [];

    public function __construct(
        private int|null $id,
        private int $usuario_id,
        private string $provincia,
        private string $localidad,
        private string $direccion,
        private float $coste,
        private string $estado,
        private string $fecha,
        private string $hora
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

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }

    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getCoste()
    {
        return $this->coste;
    }

    public function setCoste($coste)
    {
        $this->coste = $coste;

        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    public function getErrores(): array
    {
        return self::$errores;
    }

    public function validate(): bool
    {
        self::$errores = [];

        if (empty($this->provincia)) {
            self::$errores['provincia'] = 'La provincia es obligatoria.';
        }

        if (empty($this->localidad)) {
            self::$errores['localidad'] = 'La localidad es obligatoria.';
        }

        if (empty($this->direccion)) {
            self::$errores['direccion'] = 'La dirección es obligatoria.';
        }

        return empty(self::$errores);
    }

    public function sanitize(): void
    {
        $this->provincia = filter_var($this->provincia, FILTER_SANITIZE_STRING);
        $this->localidad = filter_var($this->localidad, FILTER_SANITIZE_STRING);
        $this->direccion = filter_var($this->direccion, FILTER_SANITIZE_STRING);
        $this->coste = filter_var($this->coste, FILTER_SANITIZE_NUMBER_FLOAT);
        $this->estado = filter_var($this->estado, FILTER_SANITIZE_STRING);
        $this->fecha = filter_var($this->fecha, FILTER_SANITIZE_STRING);
        $this->hora = filter_var($this->hora, FILTER_SANITIZE_STRING);
    }

    public static function fromArray(array $data): Order
    {
        return new Order(
            (int)$data['id'] ?? null,
            (int)$data['usuario_id'] ?? null,
            $data['provincia'] ?? '',
            $data['localidad'] ?? '',
            $data['direccion'] ?? '',
            (float)$data['coste'] ?? '',
            $data['estado'] ?? '',
            date('Y-m-d'),
            date('H:i:s')
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'provincia' => $this->provincia,
            'localidad' => $this->localidad,
            'direccion' => $this->direccion,
            'coste' => $this->coste,
            'estado' => $this->estado,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
        ];
    }
}
