<?php

/**
 * Prints out the board in HTML
 * 
 * @param array $board The board array to print
 * @return void
 */
function printBoard($board) {
    echo "<table>";
    foreach ($board as $row) {
        echo "<tr>";
        foreach ($row as $column) {
            echo "<td class=\"cell$column\"></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

/**
 * Creates a 2D array of $size length
 * 
 * @param int $size The length of the array and its subarrays
 * @return array $board
 */
function createBoard($size) {
    $board = [];
    for ($i = 0; $i < $size; $i++) {
        $row = [];
        for ($j = 0; $j < $size; $j++) {
            array_push($row, 0);
        }
        array_push($board, $row);
    }
    return $board;
}

/**
 * Get all the positions that a queen on (x,y) can take
 * 
 * @param array $illegalPositions The array of illegal positions
 * @param int $x The x coordinate (column)
 * @param int $y The y coordinate (row)
 * @return array $illegalPositions
 */
function getIllegalPositions($illegalPositions, $x, $y) {
    for ($i = 0; $i < count($illegalPositions); $i++) {
        for ($j = 0; $j < count($illegalPositions); $j++) {
            // horizontal
            if ($i == $y) {
                $illegalPositions[$i][$j] = 1;
            }
            // vertical
            if ($j == $x) {
                $illegalPositions[$i][$j] = 1;
            }
            // diagonal
            if ($i - $j == $y - $x) {
                $illegalPositions[$i][$j] = 1;
            }
            if ($i + $j == $x + $y) {
                $illegalPositions[$i][$j] = 1;
            }
        }
    }
    return $illegalPositions;
}

/**
 * 
 */
function checkPositions($startPosition, $illegalPositions, $occupiedPositions) {
    $occupiedPositions[0][$startPosition] = 1;
    $illegalPositions = getIllegalPositions($illegalPositions, $startPosition, 0);
    $triedPositions = [];
    $triedPositions[0] = $startPosition;
    
    $uncheckedPositions = true;
    while ($uncheckedPositions) {
        for ($i = 0; $i < count($illegalPositions); $i++) {
            for ($j = 0; $j < count($illegalPositions); $j++) {
                if ($illegalPositions[$i][$j] == 0) {
                    $occupiedPositions[$i][$j] = 1;
                    $triedPositions[$i] = $j;
                    $illegalPositions = getIllegalPositions($illegalPositions, $j, $i);
                    break;
                }
            }
        }
        $tryPosition;
        $uncheckedPositions = false;
        printBoard($occupiedPositions);
    }
    // count queens on each row -> if equals array size, solution is valid
    $sum = 0;
    foreach ($occupiedPositions as $row) {
        $sum += array_sum($row);
    }
    echo $sum == count($occupiedPositions) ? 'success :)' : 'not a valid solution :(';
    var_dump($triedPositions);
}

function calculatePositions($size) {
    // create 2d arrays for storing informations
    $board = createBoard($size);
    $illegalPositions = $board;
    $occupiedPositions = $board;
    $queenPositions = $board;

    // if a 7x7 board has 7 queens, exactly one queen must exist on each row
    // take each start position on the first row and iterate from there
    checkPositions(5, $illegalPositions, $occupiedPositions);
    // for ($i = 0; $i < count($board); $i++) {
    //     checkPositions($i, $illegalPositions, $occupiedPositions);
    // }

    $illegalPositions = getIllegalPositions($illegalPositions, 3, 3);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schaakprobleem</title>
    <style>
        table {
            border: 1px solid black;
            background-color: #ccc;
        }
        td {
            width: 20px;
            height: 20px;
            background-color: white;
        }
        .cell1 {
            background-color: red;
        }
    </style>
</head>
<body>
    <?= calculatePositions(7) ?>
</body>
</html>