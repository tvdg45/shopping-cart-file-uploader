<?php
    //Author: Timothy van der Graaff
    require_once TIMOTHYS_DIGITAL_SOLUTIONS_COMPONENT_FILE_PATH . '/config.php';
    
    abstract class Manage_Files extends Config {
        
        public static $connection;
        
        //global variables
        private static $file_path;
        private static $all_database_thumbnails = array();
        private static $all_file_thumbnails = array();
        
        //mutators
        protected static function set_file_path($this_file_path) {
            
            self::$file_path = $this_file_path;
        }
        
        //accessors
        private static function get_file_path() {
            
            return self::$file_path;
        }
        
        
        
        protected static function create_new_company_items_for_sale_table() {
            
            self::$connection->prepare(
                    
                    'CREATE TABLE company_items_for_sale ' .
                    '(row_id INT NOT NULL, item TEXT NOT NULL, ' .
                    'thumbnail TEXT NOT NULL, category TEXT NOT NULL, ' .
                    'description TEXT NOT NULL, price DECIMAL(10,2) NOT NULL, ' .
                    'inventory INT NOT NULL, date_received TEXT NOT NULL, time_received TEXT NOT NULL, ' .
                    'PRIMARY KEY (row_id)) ENGINE = MYISAM;')->execute();
        }
        
        protected static function create_new_sale_item_pictures_table() {
            
            self::$connection->prepare(
                    
                    'CREATE TABLE company_item_pictures ' .
                    '(row_id INT NOT NULL, item_id INT NOT NULL, ' .
                    'thumbnail TEXT NOT NULL, date_received TEXT NOT NULL, time_received TEXT NOT NULL, ' .
                    'PRIMARY KEY (row_id)) ENGINE = MYISAM;')->execute();
        }
        
        protected static function create_new_shopping_cart_items_table() {
            
            self::$connection->prepare(
                    
                    'CREATE TABLE company_shopping_cart_items ' +
                    '(row_id INT NOT NULL, item TEXT NOT NULL, ' +
                    'thumbnail TEXT NOT NULL, category TEXT NOT NULL, ' +
                    'description TEXT NOT NULL, price DECIMAL(10,2) NOT NULL, ' +
                    'quantity INT NOT NULL, raw_time_received TEXT NOT NULL, session TEXT NOT NULL, ' +
                    'item_id INT NOT NULL, date_received TEXT NOT NULL, time_received TEXT NOT NULL, ' +
                    'PRIMARY KEY (row_id)) ENGINE = MYISAM;')->execute();
        }
        
        protected static function search_for_sale_items() {
            
            $output = '';
            $record_count = 0;
            
            $query = self::$connection->prepare('SELECT row_id FROM company_items_for_sale WHERE thumbnail = :prepare_file_path ORDER BY row_id DESC');
            
            $query->bindValue(':prepare_file_path', self::get_file_path());
            
            if ($query->execute() === false) {
                
                $sql_error_info = $query->errorInfo();
                
                error_log('[' . $sql_error_info[0] . ']' . '[' . $sql_error_info[1] . ']' . '[' . $sql_error_info[2] . '.][Occurred on ' . date('l, F jS, Y') . ' at ' . date('h:i:s A') . ' (' . date_default_timezone_get() . ' time zone)' , 0);
                
                self::create_new_company_items_for_sale_table();
                
                $output = 'fail';
            } else {
                
                while ($query->fetchObject()) {
                    
                    $record_count++;
                }
                
                if ($record_count < 1) {
                    
                    $output = 'no file found';
                } else {
                    
                    $output = 'file found';
                }
            }
            
            return $output;
        }
        
        protected static function search_for_sale_item_pictures() {
            
            $output = '';
            $record_count = 0;
            
            $query = self::$connection->prepare('SELECT row_id FROM company_item_pictures WHERE thumbnail = :prepare_file_path ORDER BY row_id DESC');
            
            $query->bindValue(':prepare_file_path', self::get_file_path());
            
            if ($query->execute() === false) {
                
                $sql_error_info = $query->errorInfo();
                
                error_log('[' . $sql_error_info[0] . ']' . '[' . $sql_error_info[1] . ']' . '[' . $sql_error_info[2] . '.][Occurred on ' . date('l, F jS, Y') . ' at ' . date('h:i:s A') . ' (' . date_default_timezone_get() . ' time zone)' , 0);
                
                self::create_new_sale_item_pictures_table();
                
                $output = 'fail';
            } else {
                
                while ($query->fetchObject()) {
                    
                    $record_count++;
                }
                
                if ($record_count < 1) {
                    
                    $output = 'no file found';
                } else {
                    
                    $output = 'file found';
                }
            }
            
            return $output;
        }
        
        protected static function search_for_all_sale_items() {
            
            $query = self::$connection->prepare('SELECT thumbnail FROM company_items_for_sale ORDER BY row_id DESC');
            
            if ($query->execute() === false) {
                
                $sql_error_info = $query->errorInfo();
                
                error_log('[' . $sql_error_info[0] . ']' . '[' . $sql_error_info[1] . ']' . '[' . $sql_error_info[2] . '.][Occurred on ' . date('l, F jS, Y') . ' at ' . date('h:i:s A') . ' (' . date_default_timezone_get() . ' time zone)' , 0);
                
                self::create_new_company_items_for_sale_table();
            } else {
                
                while ($extract = $query->fetchObject()) {
                    
                    array_push(self::$all_database_thumbnails, str_replace(self::domain() .
                            '/third-party/items-for-sale/admin-manage-for-sale-items/photos/',
                            self::path() . '/photos/',
                            $extract->thumbnail));
                }
            }
        }
        
        protected static function search_for_all_sale_item_pictures() {
            
            $query = self::$connection->prepare('SELECT thumbnail FROM company_item_pictures ORDER BY row_id DESC');
            
            if ($query->execute() === false) {
                
                $sql_error_info = $query->errorInfo();
                
                error_log('[' . $sql_error_info[0] . ']' . '[' . $sql_error_info[1] . ']' . '[' . $sql_error_info[2] . '.][Occurred on ' . date('l, F jS, Y') . ' at ' . date('h:i:s A') . ' (' . date_default_timezone_get() . ' time zone)' , 0);
                
                self::create_new_sale_item_pictures_table();
            } else {
                
                while ($extract = $query->fetchObject()) {
                    
                    array_push(self::$all_database_thumbnails, str_replace(self::domain() .
                            '/third-party/items-for-sale/admin-manage-for-sale-items/photos/',
                            self::path() . '/photos/',
                            $extract->thumbnail));
                }
            }
        }
        
        protected static function search_for_all_shopping_cart_items() {
            
            $query = self::$connection->prepare('SELECT thumbnail FROM company_shopping_cart_items ORDER BY row_id DESC');
            
            if ($query->execute() === false) {
                
                $sql_error_info = $query->errorInfo();
                
                error_log('[' . $sql_error_info[0] . ']' . '[' . $sql_error_info[1] . ']' . '[' . $sql_error_info[2] . '.][Occurred on ' . date('l, F jS, Y') . ' at ' . date('h:i:s A') . ' (' . date_default_timezone_get() . ' time zone)' , 0);
                
                self::create_new_shopping_cart_items_table();
            } else {
                
                while ($extract = $query->fetchObject()) {
                    
                    array_push(self::$all_database_thumbnails, str_replace(self::domain() .
                            '/third-party/items-for-sale/admin-manage-for-sale-items/photos/',
                            self::path() . '/photos/',
                            $extract->thumbnail));
                }
            }
        }
        
	protected static function number_of_files() {
            
            $output = 0;
            
            $files = glob(self::path() . "/photos/*");
            
            if ($files) {
                
                $output = count($files);
            }
            
            return $output;
	}
	
	protected static function search_entire_file_directory() {
            
            array_multisort(array_map('filemtime', ($output = glob(self::path() . "/photos/*", GLOB_BRACE))), SORT_DESC, $output);
            
            return $output;
	}
        
        protected static function erase_unused_files() {
            
            self::$all_file_thumbnails = self::search_entire_file_directory();
            
            for ($i = 0; $i < sizeOf(self::$all_file_thumbnails); $i++) {
                
                if (!(in_array(self::$all_file_thumbnails[$i], self::$all_database_thumbnails))) {
                    
                    unlink(self::$all_file_thumbnails[$i]);
                }
            }
        }
    }
