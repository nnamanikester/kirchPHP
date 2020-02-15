<?php

    namespace models;

    require_once $_SERVER["DOCUMENT_ROOT"] . "/database/db.php";

    use database\DB;
    use mysqli;

    class Model extends DB {

        private $where;
        private $data;
        private $delete;

        public function __construct() {
            $this->load_data();
            $this->conn = new mysqli($this->db_host, $this->db_username, $this->db_password, $this->db_database) or die("Unable To Connect To Database: <br><br> Reason => " . $this->conn->error);
        }

        public function table_exists($table_name) 
        {
            $sql = "SELECT 1 FROM $table_name";
            if($this->conn->query($sql) !== False) {
                return True;
            }
            return False;
        }

        public function find($id)
        {
            return $this->where('id', '=', $id)->get();
        }

        public function select_all() 
        {
            $sql = "SELECT * FROM $this->table_name";
            $data = $this->conn->query($sql);
            if($data->num_rows > 0) {
                return $data;
            }
        }

        public function select($columns)
        {
            $cols = '';
            foreach($columns as $key => $c)
            {
                if($key === 0) {
                    $cols .= $c;
                } else {
                    $cols .= ', ' . $c;
                }
            }
            $sql = "SELECT $cols FROM $this->table_name ";
            $data = $this->conn->query($sql);
            if($data->num_rows > 0) {
                return $data;
            }
        }

        public function where($column, $sign, $value)
        {
            $sql = "SELECT * FROM $this->table_name WHERE $column $sign '$value'";
            if(empty($this->conn->query($sql)->fetch_assoc()))
            {
                $this->where = $sql;
                return $this;
            }
            $this->data = $sql;
            $this->delete = "WHERE $column $sign '$value'";
            return $this;
        }

        public function orWhere($column, $sign, $value)
        {
            $sql = "$this->where OR $column $sign '$value'";
            if($this->where) 
            {
                if(empty($this->conn->query($sql)->fetch_assoc()))
                {
                    $this->where = $sql;
                    return $this;
                }
                $this->data = $sql;
                $this->delete = "WHERE $column $sign '$value'";
                return $this;
            }
            return $this;
        }

        public function orderBy($column, $order)
        {
            $order = strtoupper($order);
            $sql = "$this->data ORDER BY $column $order";
            if($this->data) 
            {
                if(empty($this->conn->query($sql)->fetch_assoc()))
                {
                    $this->where = $sql;
                    return $this;
                }
                $this->data = $sql;
                return $this;
            }
            return $this;
        }

        public function get()
        {
            if($this->data)
            {
                $data = $this->conn->query($this->data);
                if($data->num_rows == 0)
                {
                    return;
                }
                return $data;
            }
            return $this;
        }

        public function take($count)
        {
            $sql = "$this->data LIMIT $count";
            if($this->data)
            {
                $data = $this->conn->query($sql);
                if($data->num_rows == 0)
                {
                    return;
                }
                return $data;
            }
            return $this;
        }

        public function create($data)
        {
            $columns = '';
            $values = '';
            $cnt = 1;
            foreach($data as $key => $value)
            {
                if($cnt === 1)
                {
                    $columns .= $key;
                    $values .= $value;
                } else {
                    $columns .= ', ' . $key;
                    $values .= ', ' . $value;
                }
                $cnt++;
            }
            $sql = "INSERT INTO $this->table_name ($columns) VALUES ($values)";
            $this->conn->query($sql);
            return $this;
        }

        public function update($data)
        {
            $updates = '';
            $cnt = 1;
            foreach($data as $key => $value)
            {
                if($cnt === 1)
                {
                    $updates = $key . ' = ' . $value;
                } else {
                    $updates = ', ' . $key . ' = ' . $value;
                }
                $cnt++;
            }
            $sql = "UPDATE $this->table_name SET ($updates)";
            $this->conn->query($sql);
            return $this;
        }

        public function delete()
        {
            $sql = "DELETE FROM $this->table_name $this->delete";
            $this->conn->query($sql);
            return $this;
        }

        public function redirect($url)
        {
            header("location: $url");
            return $this;
        }

    }