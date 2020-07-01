<?php
    header("Access-Control-Allow-Origin: https://tdscloud-dev-ed--c.visualforce.com");
    header("Content-type: application/x-www-form-urlencoded");

    //This constant is for PHP class files.
    define('TIMOTHYS_DIGITAL_SOLUTIONS_COMPONENT_FILE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/third-party/items-for-sale/admin-manage-for-sale-items');
    
    require_once TIMOTHYS_DIGITAL_SOLUTIONS_COMPONENT_FILE_PATH . '/config.php';
    require_once TIMOTHYS_DIGITAL_SOLUTIONS_COMPONENT_FILE_PATH . '/controllers/control-manage-files.php';
    
    //Establish database connection.
    $database_connection = new PDO(Config::database_server_database_name(), Config::database_username(), Config::database_password());
    
    $item_name = filter_input(INPUT_POST, 'item_name');
    $item_category = filter_input(INPUT_POST, 'item_category');
    $item_description = filter_input(INPUT_POST, 'item_description');
    $item_price = filter_input(INPUT_POST, 'item_price');
    $item_inventory = filter_input(INPUT_POST, 'item_inventory');
    $add_item = filter_input(INPUT_POST, 'add_item');
    $change_item = filter_input(INPUT_POST, 'change_item');
    $add_picture = filter_input(INPUT_POST, 'add_picture');
    $file_search_result = '';

    //Indicate the directory.  Do not include any forward or backward slashes.
    $upload_directory = 'photos';
    
    $response = array(
        
        'status' => 0,
        'message' => 'Form submission failed, please try again.'
    );

    //If form is submitted
    if ($add_item == 'Add item') {
        
        if (isset($item_name) && !(ctype_space($item_name))
                && isset($item_category) && !(ctype_space($item_category)) && !(ctype_space($item_description))
                && isset($item_price) && !(ctype_space($item_price)) && is_numeric($item_price)
                && $item_price >= 0.01 && isset($item_inventory) && !(ctype_space($item_inventory))
                && is_numeric($item_inventory) && $item_inventory >= 0) {
				
            if (!(empty($_FILES["item_thumbnail"]["name"]))) { 
                 
                //File path config 
                $file_name = basename($_FILES["item_thumbnail"]["name"]); 
                $target_file_path = $upload_directory . '/' . $file_name; 
                $file_type = pathinfo($target_file_path, PATHINFO_EXTENSION); 
                 
                //Allow certain file formats 
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
                
                if (in_array($file_type, $allowed_types)) {

                    //Check to see if a picture by that file spelling already exists in the "photos" directory.
                    Control_Manage_Files::$use_connection = $database_connection;
                    Control_Manage_Files::$file_path = Config::domain() . '/third-party/items-for-sale/admin-manage-for-sale-items/' . $target_file_path;
                    $file_search_result = Control_Manage_Files::control_search_existing_files();
                    
                    if ($file_search_result == 'file can be used') {
                        
                        //Upload file to the server
                        if (move_uploaded_file($_FILES["item_thumbnail"]["tmp_name"], $target_file_path)){
                            
                            $response['status'] = 1;
                            $response['message'] = 'success';
                        } else {
                            
                            $response['message'] = '<label><span style="color: red">Sorry, there was an error uploading your file.</span></label>';
                        }
                    } else if ($file_search_result == 'file already used') {
                        
                        $response['message'] = '<label><span style="color: red">Sorry, that file already exists.  Try using a different file spelling, and upload file after doing so.</span></label>';
                    } else {
                        
                        $response['message'] = '<label><span style="color: red">Sorry, there was an error uploading your file.</span></label>';
                    }
                } else {
                    
                    $response['message'] = '<label><span style="color: red">Sorry, only JPG, JPEG, PNG, GIF, and BMP files are allowed to upload.</span></label>'; 
                }
            } else {
                
                $response['message'] = '<label><span style="color: red">Please choose an image.</span></label>';
            }
        } else {
            
            $response['message'] = '<label><span style="color: red">Item name is required.<br />Category is required.<br />Non-space characters are required for desription.  Otherwise, leave this field blank.<br />Price of at least 0.01 is required.<br />Inventory of at least 0 is required.</span></label>';
        }
    }
    
    //If form is submitted
    if ($change_item == 'Change item') {
        
        if (isset($item_name) && !(ctype_space($item_name))
                && isset($item_category) && !(ctype_space($item_category)) && !(ctype_space($item_description))
                && isset($item_price) && !(ctype_space($item_price)) && is_numeric($item_price)
                && $item_price >= 0.01 && isset($item_inventory) && !(ctype_space($item_inventory))
                && is_numeric($item_inventory) && $item_inventory >= 0) {
				
            if (!(empty($_FILES["item_thumbnail"]["name"]))) { 
                 
                //File path config 
                $file_name = basename($_FILES["item_thumbnail"]["name"]); 
                $target_file_path = $upload_directory . '/' . $file_name; 
                $file_type = pathinfo($target_file_path, PATHINFO_EXTENSION); 
                 
                //Allow certain file formats 
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
                
                if (in_array($file_type, $allowed_types)) {

                    //Check to see if a picture by that file spelling already exists in the "photos" directory.
                    Control_Manage_Files::$use_connection = $database_connection;
                    Control_Manage_Files::$file_path = Config::domain() . '/third-party/items-for-sale/admin-manage-for-sale-items/' . $target_file_path;
                    $file_search_result = Control_Manage_Files::control_search_existing_files();
                    
                    if ($file_search_result == 'file can be used') {
                        
                        //Upload file to the server
                        if (move_uploaded_file($_FILES["item_thumbnail"]["tmp_name"], $target_file_path)){
                            
                            $response['status'] = 1;
                            $response['message'] = 'success';
                        } else {
                            
                            $response['message'] = '<label><span style="color: red">Sorry, there was an error uploading your file.</span></label>';
                        }
                    } else if ($file_search_result == 'file already used') {
                        
                        $response['message'] = '<label><span style="color: red">Sorry, that file already exists.  Try using a different file spelling, and upload file after doing so.</span></label>';
                    } else {
                        
                        $response['message'] = '<label><span style="color: red">Sorry, there was an error uploading your file.</span></label>';
                    }
                } else {
                    
                    $response['message'] = '<label><span style="color: red">Sorry, only JPG, JPEG, PNG, GIF, and BMP files are allowed to upload.</span></label>'; 
                }
            } else {
                
                $response['message'] = '<label><span style="color: red">Please choose an image.</span></label>';
            }
        } else {
            
            $response['message'] = '<label><span style="color: red">Item name is required.<br />Category is required.<br />Non-space characters are required for desription.  Otherwise, leave this field blank.<br />Price of at least 0.01 is required.<br />Inventory of at least 0 is required.</span></label>';
        }
    }
    
    //If form is submitted
    if ($add_picture == 'Add picture') {
        
        if (!(empty($_FILES["item_additional_thumbnail"]["name"]))) {

            //File path config
            $file_name = basename($_FILES["item_additional_thumbnail"]["name"]);
            $target_file_path = $upload_directory . '/' . $file_name;
            $file_type = pathinfo($target_file_path, PATHINFO_EXTENSION);

            //Allow certain file formats
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
            
            if (in_array($file_type, $allowed_types)) {

                //Check to see if a picture by that file spelling already exists in the "photos" directory.
                Control_Manage_Files::$use_connection = $database_connection;
                Control_Manage_Files::$file_path = Config::domain() . '/third-party/items-for-sale/admin-manage-for-sale-items/' . $target_file_path;
                $file_search_result = Control_Manage_Files::control_search_existing_files();
                
                if ($file_search_result == 'file can be used') {

                    //Upload file to the server
                    if (move_uploaded_file($_FILES["item_additional_thumbnail"]["tmp_name"], $target_file_path)){
                        
                        $response['status'] = 1;
                        $response['message'] = 'success';
                    } else {
                        
                        $response['message'] = '<label><span style="color: red">Sorry, there was an error uploading your file.</span></label>';
                    }
                } else if ($file_search_result == 'file already used') {
                    
                    $response['message'] = '<label><span style="color: red">Sorry, that file already exists.  Try using a different file spelling, and upload file after doing so.</span></label>';
                } else {
                    
                    $response['message'] = '<label><span style="color: red">Sorry, there was an error uploading your file.</span></label>';
                }
            } else {
                
                $response['message'] = '<label><span style="color: red">Sorry, only JPG, JPEG, PNG, GIF, and BMP files are allowed to upload.</span></label>';
            }
        } else {
            
            $response['message'] = '<label><span style="color: red">Please choose an image.</span></label>';
        }
    }    
    
    //Return response
    echo json_encode($response);
