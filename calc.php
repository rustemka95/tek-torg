<input type="button" onclick="history.back(-2); return false;" value="Назад"/><br>

<?php

function calculate(int $rock, $bug)
{

    echo '<table border = 1>
    <tr>
        <th>Номер жука</th>
        <th>Слева</th>
        <th>Позиция</th>
        <th>Справа</th>
    </tr>';

    $maxRast = $rock; //изначально максимальная длина отрезка = длине отрезка
    $maxStart = 1; //Начало самого длинного отрезка изначально = 1
    $location[0] = 1;  //обозначил левую границу отрезка
    $location[$rock + 1] = 1; //обозначил правую границу отрезка
    for ($i = 1; $i <= $bug; $i++) { //цикл выполняется, пока жуки не закончатся
        $right = floor($maxRast / 2); //из длины отрезка отнимаем текущую ячейку и находим кол-во свободных ячеек справа
        $left = $maxRast - $right - 1; //из длины отрезка отнимаем кол-во свободных ячеек справа и -1, т.к. одну ячейку мы заняли жуком
        $pos = $maxStart + $left; //позиция жука
        $location[$pos] = 1; //Записываем позицию жука в массив
        ksort($location); //сортируем массив
        // находим самый длинный отрезок
        $prevKey = 0;
        $maxRast = 0;
        foreach ($location as $key => $value) {
            $rast = $key - $prevKey - 1; //расстояние между текущей точкой и предыдущей. -1 т.к. нумерация с 0
            if ($rast > $maxRast) {
                $maxRast = $rast; //находим самый длинный отрезок
                $maxStart = $key - $maxRast; //находим позицию, с которой начинается самый длинный отрезок
            }
            $prevKey = $key; //сохраняем значение для следующей итерации
        }
        echo '<tr>
                <th>' . $i . '</th>
                <th>' . $left . '</th>
                <th>' . $pos . '</th>
                <th>' . $right . '</th>
            </tr>';
    }

}

if (!empty($_POST['rock']) && !empty($_POST['bug'])) {
    $rock = (htmlentities($_POST['rock']));
    $bug = (htmlentities($_POST['bug']));
    if (!is_numeric($rock) || !is_numeric($bug)) {
        throw new Exception('Введите число!');
    }
    if ($rock >= $bug) {
        calculate((int)$rock, (int)$bug);
    } else {
        throw new Exception('Количество жуков больше количества камней!');
    }
} else {
    throw new Exception('Введите количество камней и жуков');
}


