<?php

namespace route;

$route = new Route();

$route->setRoute('vacas/ver', array(
    'cod' => 'integerFilter'
));
$route->setRoute('index/gordo', array(
    'cod' => 'integerFilter'
));

$route->init();