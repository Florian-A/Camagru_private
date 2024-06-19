<?php

header('Content-Type: application/json');

require 'database.php';
require 'router.php';

routeRequest();
