<?php

    namespace models;

    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Model.php';

    use models\Model;

    class User extends Model {

        protected $table_name = 'users';

        public function users() 
        {
            $data = $this->select(['id, name']);
            $names = [];
            while($row = $data->fetch_assoc()) 
            {
                array_push($names, $row); 
            }
            return $names;
        }

    }