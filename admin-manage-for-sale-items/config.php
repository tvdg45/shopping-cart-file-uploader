<?php
    //Author: Timothy van der Graaff
    class Config {
        
        public static function path() {
            
            $output = '';
            
            define('PATH', $_SERVER['DOCUMENT_ROOT'] . '/third-party/items-for-sale/admin-manage-for-sale-items');
            
            $output .= PATH;
            
            return $output;
        }
        
        public static function domain() {
            
            $output = '';
            
            define('DOMAIN', 'https://www.timothysdigitalsolutions.com');
            
            $output .= DOMAIN;
            
            return $output;
        }
        
        public static function database_server_database_name() {
            
            $output = '';
            
            define('DATABASE_SERVER', 'server');
            
            define('DATABASE_NAME', 'database');

            //This following code is for local testing purposes only.  Attempting to execute on a remote server could cause errors.
            /*$connection = @mysqli_connect(DATABASE_SERVER, $this->database_username(), $this->database_password());
            @mysqli_query($connection, 'CREATE DATABASE IF NOT EXISTS ' . DATABASE_NAME);*/
            
            $output .= 'mysql:host=' . DATABASE_SERVER . ';dbname=' . DATABASE_NAME;
            
            return $output;
        }
        
        public static function database_username() {
            
            $output = '';
            
            define('DATABASE_USERNAME', 'username');
            
            $output .= DATABASE_USERNAME;
            
            return $output;
        }
        
        public static function database_password() {
            
            $output = '';
            
            define('DATABASE_PASSWORD', 'password');
            
            $output .= DATABASE_PASSWORD;
            
            return $output;
        }
        
        public static function website_name() {
            
            $output = '';
            
            define('WEBSITE_NAME', 'TDS Shopping Cart');
            
            $output .= WEBSITE_NAME;
            
            return $output;
        }
        
        public static function email_address() {
            
            $output = '';
            
            define('EMAIL', 'timothys@timothysdigitalsolutions.com');
            
            $output .= EMAIL;
            
            return $output;
        }
    }
