<?php

namespace CliApp;

//Register custom autoloader
spl_autoload_register(function ($class_name) {
    include str_replace("CliApp\\", "", $class_name . '.php');
});