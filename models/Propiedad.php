<?php

namespace Model;

class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 
    'creado', 'vendedores_id'];


    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = 'Debes añadir un título';
        }
        if(!$this->precio) {
            self::$errores[] = 'El Precio es Obligatorio';
        }
        if(!$this->precio > 99999999) {
            self::$errores[] = 'El Precio es Demasiado Alto';
        }
        if(strlen($this->descripcion) < 50 ) {
            self::$errores[] = 'La Descripcion es Obligatoria y debe tener al menos 50 carácteres';
        }
        if(!$this->habitaciones) {
            self::$errores[] = 'El Número de  Habitaciones es Obligatorio';
        }
        if(!$this->wc) {
            self::$errores[] = 'El Número de  Baños es Obligatorio';
        }
        if(!$this->estacionamiento) {
            self::$errores[] = 'El Número de Lugares de Estacionamiento es Obligatorio';
        }
        if(!$this->vendedores_id) {
            self::$errores[] = 'Seleccione un Vendedor';
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es Obligatoria";
        }

        return self::$errores;
    }

}