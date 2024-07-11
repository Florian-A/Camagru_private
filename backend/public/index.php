<?php

//error_reporting(0);
header('Content-Type: application/json');

require 'database.php';
require 'router.php';

routeRequest();
