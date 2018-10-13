<?php

/**
 * You have to run scipt such as
 * php index.php test=3,5,6,2,7,9,24,6,4,22 test=2,7,5,4,9,5
 * It must return result like 'Result of the 3,5,6,2,7,9,24,6,4,22 is 18'
 *
 * If there is no test params it takes arrays by default
 */

if (is_array($argv) && count($argv) > 1) {
    $toFindArgument = preg_grep('/test/', $argv);

    foreach ($toFindArgument as $item) {
        $arraysForTesting[] = explode('=', $item);
    }
}

if (!isset($arraysForTesting)) {
    $arraysForTesting = [
        ['1,3,2,1,2,1,5,3,3,4,2'],
        ['5,8'],
        ['1,2,1,3,6,2,3,5,3,2,1']
    ];
}

foreach ($arraysForTesting as $item) {
    $tmpLastItem = end($item);
    $array = explode(',', $tmpLastItem);
    $result = solution($array);

    echo 'Result of  the ' . end($item) . ' is ' . $result . PHP_EOL;
}


/**
 * @param array $data
 * @return mixed
 */
function solution(array $data)
{
    $dataDiff[] = 0;

    for ($i = 0; $i < count($data); $i++) {

        for ($k = 1; $k < count($data); $k++) {

            if ($i > $k) continue;

            if (isset($data[$i - 1]) && isset($data[$i + 1]) && isset($data[$k - 1]) && isset($data[$k + 1])) {
                if (($data[$i] > $data[$i - 1] && $data[$i] > $data[$i + 1])
                    && ($data[$k] > $data[$k - 1] && $data[$k] > $data[$k + 1])
                    && ($data[$i] > $data[$k] || $data[$i] < $data[$k] || $data[$i] == $data[$k])
                ) {
                    $bufArr = array_slice($data, $i, $k);
                    $dataDiff[] = min([reset($bufArr), end($bufArr)]) - min($bufArr);
                }
            }
        }
    }

    return max($dataDiff);
}