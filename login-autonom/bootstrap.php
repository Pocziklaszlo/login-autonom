<?php

include_once 'config.php';
include_once 'pdoHandler.php';
include_once 'data.php';
include_once 'repository.php';

$pdo = (new PdoHandler($database))->createPdoInstance();

$data = new Data($pdo);

$repository = new Repository($data);
