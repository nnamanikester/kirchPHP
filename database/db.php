<?php
    namespace database;

    class DB {

        protected $db_host;
        protected $db_database;
        protected $db_username;
        protected $db_password;

        public $conn;

        public function load_data()
        {
            // $this->db_host = env('DB_HOST');
            // $this->db_database = env('DB_DATABASE');
            // $this->db_username = env('DB_USERNAME');
            // $this->db_password = env('DB_PASSWORD');

            $this->db_host = 'localhost';
            $this->db_database = 'forum';
            $this->db_username = 'root';
            $this->db_password = '';
        }

    }