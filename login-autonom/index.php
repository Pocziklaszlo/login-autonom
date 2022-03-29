<?php

include_once 'bootstrap.php';

$url = $_SERVER['REQUEST_URI'];

$segment = '';
if(preg_match('#index\.php\/([\w-]+)#ui',$url,$match)){
    $segment = trim($match[1]);
}

/**
 * Small routing
 */
if($segment == 'loadData'){

    $page = (isset($_GET['page']) > 0) ? (int)$_GET['page'] : 1;

    $employeeData = $repository->getEmployeeData($page);

    $employeeData['pageData']['nextPage'] = $page + 1;

    echo json_encode($employeeData);

}