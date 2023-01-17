<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');


    // Возвращение ОК
    function return_ok($data, $code) {
        http_response_code($code);
        $result = [
            "ok" => true,
            "result" => $data
        ];
        header('Content-Type: application/json');
        echo json_encode_objs($result);
        die();
    }

    // Возвращение ошибки
    function return_error($detail, $code) {
        http_response_code($code);
        $result = [
            "ok" => false,
            "detail" => $detail,
            "code" => $code
        ];
        header('Content-Type: application/json');
        echo json_encode_objs($result);
        die();
    }

    // Функция для вывода json-объекта
    function json_encode_objs($item) {
        if (is_object($item) || (is_array($item) && isAssoc($item))) {
            $pieces = [];
            foreach ($item as $k => $v) {
                $pieces[] = "\"$k\":" . json_encode_objs($v);
            }
            return '{' . implode(',', $pieces) . '}';
        } else if (is_array($item)) {
            $pieces = array();
            foreach ($item as $k => $v) {
                $pieces[] = json_encode_objs($v);
            }
            return '[' . implode(',', $pieces) . ']';
        }else{
            return json_encode($item);
        }
    }

    // Перевод в ассоциативный массив
    function isAssoc(array $arr) {
        if ([] === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

?>