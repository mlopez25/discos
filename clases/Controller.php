<?php

class Controller {

    private $modelo, $sesion, $usuario;

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
        $this->sesion = Session::getInstance('discos');
        
    }

    function getModel() {
        return $this->modelo;
    }
    
    function getSession() {
        return $this->sesion;
    }
    
    function getDiskPageController(){
        return $this->getModel()->getDiscosPageController(Request::get('pagina'));
    }
    
    function getUsuarioPageController(){
        return $this->getModel()->getUsuarioPageController(Request::get('pagina'));
    }

    /* acciones */

    function main() {
        if($this->sesion->isLogged()){
            $this->modelo->addFile('aside', Util::renderFile('template/html/aside/aside-usuario.html'));
            $this->modelo->addFile('paginacion', Util::renderFile('template/html/paginacion/paginacion.html'));
            header('Location: index.php?ruta=disco&accion=viewlistadiscos');
        } else {
            $this->modelo->addFile('aside', Util::renderFile('template/html/aside/aside-visitante.html'));
            $this->modelo->addFile('paginacion', Util::renderFile('template/html/paginacion/paginacion-vacio.html'));
            header('Location: index.php?ruta=disco&accion=viewlistadiscos');
        }
    }
    
    function usuario() {
        $this->modelo->addFile('aside', Util::renderFile('template/html/aside/aside-vacio.html'));
        $this->modelo->addFile('contenido', Util::renderFile('template/html/loguearse.html'));
        $this->modelo->addFile('paginacion', Util::renderFile('template/html/paginacion/paginacion-vacio.html'));
        
    }
    
}