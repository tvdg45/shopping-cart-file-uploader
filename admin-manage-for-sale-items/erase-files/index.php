<?php
    header("Access-Control-Allow-Origin: https://tdscloud-dev-ed--c.visualforce.com");
    header("Content-type: application/x-www-form-urlencoded");

    //This constant is for PHP class files.
    define('TIMOTHYS_DIGITAL_SOLUTIONS_COMPONENT_FILE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/third-party/items-for-sale/admin-manage-for-sale-items');
    
    require_once TIMOTHYS_DIGITAL_SOLUTIONS_COMPONENT_FILE_PATH . '/config.php';
    require_once TIMOTHYS_DIGITAL_SOLUTIONS_COMPONENT_FILE_PATH . '/controllers/control-manage-files.php';
    
    //Establish database connection.
    $database_connection = new PDO(Config::database_server_database_name(), Config::database_username(), Config::database_password());
    
    $erase_unused_files = filter_input(INPUT_POST, 'erase_unused_files');

    //If form is submitted
    if ($erase_unused_files == 'Erase') {
        
        Control_Manage_Files::$use_connection = $database_connection;
        
        Control_Manage_Files::control_erase_unused_files();
        
        echo 'files erased';
    }
