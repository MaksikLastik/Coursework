<?php

    class Database {
        public function connect() {
            $host = "coursework.lab";
            $user = "root";
            $pass = "";
            $db = "el_dnevnik";
            $link = mysqli_connect($host, $user, $pass, $db);

            if (!$link) {
                return_error("Ошибка при подключении к беза данных", 400);
            }
            return $link;
        }
    }

    // Проверка запроса на сервер
    function check_query($res, $msg, $code) {
        if (gettype($res) == "boolean" || gettype($res) == "integer") {
            if ($res == 0) {
                return_error($msg, $code);
            }
        }
        return $res;
    }

?>