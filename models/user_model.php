<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');


    enum Status {
        case admin;
        case teacher;
        case student;
    }

    class User {
        public $id;
        public $email;
        public $password;
        public Status $role;


        public function __construct($email, $password) {
            $this->email = $email;
            $this->password = $password;
        }
    }


    class Student extends User {
        public $grade;
        public $name;


        public function __construct($email, $password) {
            parent::__construct($email, $password);
            $this->role = Status::student;
        }

        public function login() {
            $link = new Database();
            $link = $link->connect();

            $query = "SELECT * FROM students WHERE email = '$this->email'";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);
            $this->password .= "1234567890";
            $this->password = md5($this->password);

            if ($row['password'] == $this->password) {
                $this->grade = $row['grade_name'];
                $this->name = $row['student_name'];
                $this->id = $row['student_id'];
                return true;
            } else {
                return false;
            }
        }
    }


    class Teacher extends User {
        public $name;


        public function __construct($email, $password) {
            parent::__construct($email, $password);
            $this->role = Status::teacher;
        }

        public function login() {
            $link = new Database();
            $link = $link->connect();

            $query = "SELECT * FROM teachers WHERE email = '$this->email'";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);
            $this->password .= "1234567890";
            $this->password = md5($this->password);

            if ($row['password'] == $this->password) {
                $this->name = $row['teacher_name'];
                $this->id = $row['id'];
                return true;
            } else {
                return false;
            }
        }
    }


    class Admin extends User {
        public function __construct($email, $password) {
            parent::__construct($email, $password);
            $this->role = Status::admin;
        }

        public function login() {
            $link = new Database();
            $link = $link->connect();

            $query = "SELECT * FROM admins WHERE name = '$this->email'";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);
            $this->password .= "1234567890";
            $this->password = md5($this->password);
            mysqli_close($link);

            if ($row['password'] == $this->password) {
                $this->id = $row['id'];
                return true;
            } else {
                return false;
            }
        }
    }

?>