<?php
    //Author: Timothy van der Graaff
    require_once TIMOTHYS_DIGITAL_SOLUTIONS_COMPONENT_FILE_PATH . '/models/manage-files.php';
    
    class Control_Manage_Files extends Manage_Files {
        
        public static $use_connection;

        //global variables
        public static $file_path;
        
        public static function control_search_existing_files() {
            
            $output = '';
            
            self::$connection = self::$use_connection;
            
            self::set_file_path(self::$file_path);
            
            $search_files = self::search_for_sale_items();
            
            if ($search_files == 'no file found') {
                
                $search_files = self::search_for_sale_item_pictures();
                
                if ($search_files == 'no file found') {
                    
                    $output = 'file can be used';
                } else if ($search_files == 'file found') {
                    
                    $output = 'file already used';
                } else {
                    
                    $output = 'fail';
                }
            } else {
                
                if ($search_files == 'file found') { $output = 'file already used'; } else { $output = 'fail'; }
            }
            
            return $output;
        }
        
        public static function control_erase_unused_files() {
            
            self::$connection = self::$use_connection;
            
            if (self::number_of_files() > 0) {
                
                self::search_for_all_sale_items();
                self::search_for_all_sale_item_pictures();
                self::search_for_all_shopping_cart_items();
                self::erase_unused_files();
            }
        }
    }
