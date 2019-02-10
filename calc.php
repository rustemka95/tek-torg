<?php


function Main($rock, $bug)
{

    $location[0] = 1;  //обозначил левую границу отрезка
    $location[$rock + 1] = 1; //обозначил правую границу отрезка
    $pos = floor($rock / 2); //позиция жука
    $right = $rock - $pos; //из длины отрезка отнимаем текущую ячейку и находим кол-во свободных ячеек справа
    $left = $rock - $right - 1; //из длины отрезка отнимаем кол-во свободных ячеек справа и -1, т.к. одну ячейку мы заняли жуком
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
        $prevRast = $rast; //сохраняем значение для следующей итерации
        $prevKey = $key; //сохраняем значение для следующей итерации
    }
    echo '
        <table border = 1>
            <tr>
                <th>Номер жука</th>
                <th>Слева</th>
                <th>Позиция</th>
                <th>Справа</th>
            </tr>
        ';
    echo '<tr>
                <th>1</th>
                <th>' . $left . '</th>
                <th>' . $pos . '</th>
                <th>' . $right . '</th>
            </tr>';

    for ($i = 2; $i <= $bug; $i++) {
        $right = floor($maxRast / 2);
        $left = $maxRast - $right - 1;
        $pos = $maxStart + $left;
        $location[$pos] = 1;
        ksort($location);
        $prevKey = 0;
        $maxRast = 0;
        foreach ($location as $key => $value) {
            $rast = $key - $prevKey - 1;
            if ($rast > $maxRast) {
                $maxRast = $rast;
                $maxStart = $key - $maxRast;
            }
            $prevRast = $rast;
            $prevKey = $key;
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
    $rock = htmlentities($_POST['rock']);
    $bug = htmlentities($_POST['bug']);
    if (is_numeric($rock) && is_numeric($bug)) {
        if ($rock >= $bug) {
            main($rock, $bug);
        } else {
            echo 'Количество жуков больше количества камней!';
        }
    } else {
        echo 'Введите целое число камней и жуков';
    }
} else {
    echo 'Введите количество камней и жуков';
}


