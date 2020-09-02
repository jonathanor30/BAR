<?php 

class Productos extends Controller
{

    private $model;
    public function __construct()
    {
        $this->sessionValidator(); //Validamos sesion
        $this->model = $this->modelo('Producto', 'Productos');
    }

    public function index()
    {
        $datos =  array(
            'titulo' => 'Listado Productos',
            'listado'=> $this->model->ObtenerTodos(),
           
        );
       $this->vista('VerProducto',$datos, 'Productos');

    }

    public function VerProducto()
    {
        $datos =  array(
            'titulo' => 'Producto Garrafa de aguardiente',
            'producto'=> $this->model->ObtenerUno("NombreProducto", "CERVEZA PILSEN"),
        );
       $this->vista('VerProducto',$datos, 'Productos');
    }
    
}
