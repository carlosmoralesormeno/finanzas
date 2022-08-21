<?php 
require_once 'config/database.php';

/** Cargar la Vista */
isset($_GET['view']) ? $view = $_GET['view'] : $view = 'index';
/** Cargar la acción */
isset($_GET['action']) ? $action = $_GET['action'] : $action = 'index';

/** Ruta del controlador */
$controller_path = 'controller/'.$view.'Controller.php';

if($controller_path){
    require_once $controller_path;
    $controller_name = $view.'Controller';
    $controller = new $controller_name();
}

/** Cargar Datos del Controlador en Vista */
$data_view["data"] = array();

if(method_exists($controller,$action)) {
    $data_view["data"] = $controller->{$action}();
}

/** Mostrar html o contenido en json */
isset($_GET['datatype']) ? $datatype = $_GET['datatype'] : $datatype = 'html';

switch ($datatype) {
    case 'html':
        require_once 'view/template/header.php';
        require_once 'view/'.$view.'/'.$controller->view.'.php';
        require_once 'view/template/footer.php';
        echo '<script src="view/assets/js/'.$view.'.js"></script>';
        break;
    case 'ajax':
        require_once 'view/'.$view.'/'.$controller->view.'.php';
        echo '<script src="view/assets/js/'.$view.'.js"></script>';
        break;
}


?>