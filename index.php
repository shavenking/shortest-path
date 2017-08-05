<?php

require_once __DIR__ . '/Position.php';
require_once __DIR__ . '/Map.php';

$map = new Map($mapData = [
    [0,0,0,0,0,0,0,0,0,0],
    [0,1,0,0,0,0,0,2,0,0],
    [0,0,1,0,0,0,0,0,0,0],
    [0,0,0,1,0,0,0,0,0,0],
    [0,0,0,0,1,0,0,0,0,0],
    [0,0,0,0,0,1,0,0,0,0],
    [0,0,0,0,0,0,1,0,0,0],
    [0,3,0,0,0,0,0,1,0,0],
    [0,0,0,0,0,0,0,0,1,0],
    [0,0,0,0,0,0,0,0,0,0]
]);

$queue = [$map->start];
$map->mark($map->start); // mark position so we won't add it to queue next time
$current = array_shift($queue);

while (!$map->isEnd($current)) {
    foreach ($map->getRoadsNearBy($current) as $position) {
        // if the position is not marked then we should add to queue
        if (!$map->hasMark($position)) {
            $map->mark($position);
            $queue[] = $position;
        }
    }

    $current = array_shift($queue);

    // if we can't find any road before we find the end position
    // that means our map is broken :P
    if (!$current) {
        die('There is no way to the end position!');
    }
}

// replace 0 with - if it's the shortest path
if ($map->mapData[$current->x][$current->y] === Map::ROAD) {
    $map->mapData[$current->x][$current->y] = '-';
}

while ($current = $current->previous) {
    if ($map->mapData[$current->x][$current->y] === Map::ROAD) {
        $map->mapData[$current->x][$current->y] = '-';
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shortest Path</title>
    <style>
        td {
          width: 50px;
          height: 50px;
        }
    </style>
</head>
<body>
    <table>
        <tbody>
            <?php foreach ($map->mapData as $row): ?>
                <tr>
                    <?php foreach ($row as $col): ?>
                        <?php if ($col === '-'): ?>
                            <td style="background-color: green;">&nbsp;</td>
                        <?php elseif ($col === Map::WALL): ?>
                            <td style="background-color: red">&nbsp;</td>
                        <?php elseif ($col === Map::START): ?>
                            <td style="background-color: white">&nbsp;</td>
                        <?php elseif ($col === Map::END): ?>
                            <td style="background-color: white">&nbsp;</td>
                        <?php else: ?>
                            <td style="background-color: gray">&nbsp;</td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
