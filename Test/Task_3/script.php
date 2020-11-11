<?php

$str1 = "[people]
            [name]Иванов[/name]
            [surname]Иванов [/surname]
            [age]13 [/age]
        [/people]";
$str2 = "[people]
            [name]Иванов[/name]
            [surname]Иванов [/surname]
            [age]13 [age]
        [/people]"; //Не найден закрывающий тэг [/age]
$str3 = "[people]
            [surname]Иванов[/name]
            [/name] Иванов [/surname]
            [age]13[/age]
        [/people]"; //Не найден закрывающий тэг [/surname]. Нарушен порядок следования.

$arr = array();

$str = $str1; //Выбор строки

while ($i !== false) {
    if (stristr($str, "[")) {
        $i = true;
        $str = stristr($str, "[");
        $str = ltrim($str, "[");
        $arr[] = stristr($str, "]", true); //добавляем тэги в массив

        if (stristr(end($arr), "/") && count($arr) > 0) {
            if (ltrim(end($arr), "/") == prev($arr)) {
                array_pop($arr);
                array_pop($arr);
            } else {
                $i = count($arr);
                echo("Текст не верный (не найден закрывающий тэг [/" . $arr[$i - 2] . "]. Нарушен порядок следования)");
                $i = false;
                break;
            }
        }

        if (prev($arr) == end($arr) && count($arr) > 0) {
            echo("Текст не верный (не найден закрывающий тэг [/" . prev($arr) . "])");
            $i = false;
            break;
        }

    } else {
        $i = false;
    }
}

if (count($arr) == 0) {
    echo("Текст верный");
}
?>
