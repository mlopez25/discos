<?php

class ControllerUsuario extends Controller {
    
    function logout(){
        $this->getSession()->destroy();
        header('Location: index.php');
        exit();
    }
    
    function dologin() {
        $usuarioWeb = new Usuario();
        $usuarioWeb->read();
        
        $usuarioBD = $this->getModel()->getUsuario($usuarioWeb->getLogin());

        if( ( $usuarioWeb->getLogin() === $usuarioBD->getLogin() ) 
                && ($usuarioWeb->getPassword() === $usuarioBD->getPassword() ) ){
                    $this->getSession()->setUser($usuarioBD);
       
            header('Location: index.php?ruta=disco&accion=viewlistadiscos');
            exit();
        }
        
        $this->getSession()->destroy();
        $this->getModel()->addFile('aside', Util::renderFile('template/html/aside/aside-vacio.html'));
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion/paginacion-vacio.html'));
        return $this->getModel()->addFile('contenido', Util::renderFile('template/html/loguearse.html'));
    }
    
    function doinsert(){
        $usuario = new Usuario();
        $usuario->read();
        
        if( $usuario->isValid() ) {
            $this->getModel()->insertUsuario($usuario);
            header('Location: index.php?ruta=usuario&accion=viewusuario');
            exit();
        }
    }
    
    function doedit(){
        $usuario = new Usuario();
        $usuario->read();
        $loginpk = Request::get('loginpk');
        
        $this->getModel()->editUsuario($usuario, $loginpk);
        header('Location: index.php?ruta=usuario&accion=viewusuario');
        exit(); 
    }
    
    function dodelete(){
        $login = Request::get('login');
        
        $this->getModel()->deleteUsuario($login);
        
        header('Location: index.php?ruta=usuario&accion=viewusuario');
        exit();
    }
    
    
    /*  ********************** VIEWS ***************** */

    function viewusuario(){
        $pc = $this->getUsuarioPageController();
        $lista = $this->getModel()->getUsuarioPage($pc->getPage());
        
        $dato = '';
        
        $dato .= "<table class='tablaUsuarios'>
                    <tr>
		                <th><p>Loggin</p></th>
		                <th></th>
		                <th></th>
	                </tr>";
	    
        foreach($lista as $usuario){
            
            $dato .= "<tr>";
            $dato .= Util::renderFile( 'template/html/_usuario.html', array( 'login' => $usuario->getLogin(), 'password' => $usuario->getPassword() ) );
            $dato .= "</tr>";
        }
        
        $dato .= "</table>";
        
        $this->getModel()->addFile('aside', Util::renderFile('template/html/aside/aside-usuario.html'));
        $this->getModel()->addData('contenido', $dato);
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion/paginacion.html'), array('primera' => $pc->getFirst(), 'anterior' => $pc->getPrevious(), 'siguiente' => $pc->getNext(), 'ultima'=> $pc->getPages() ));
    }
    
    function viewadd(){
        $this->getModel()->addFile('aside', Util::renderFile('template/html/aside/aside-usuario.html'));
        $this->getModel()->addFile('contenido', Util::renderFile('template/html/addUsuarios.html'));
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion/paginacion.html'));
    }
    
    function viewedit(){
        $login = Request::get('login');
        $password = Request::get('password');

        $this->getModel()->addFile('aside', Util::renderFile('template/html/aside/aside-usuario.html'));
        $this->getModel()->addFile('contenido', Util::renderFile('template/html/editUsuario.html', array('login' => $login, 'password' => $password ) ) );
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion/paginacion.html'));
    }
    
    
}