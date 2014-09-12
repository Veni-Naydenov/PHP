<?php

$column = $_GET['column'];
$order = $_GET['order'];
$students = $_GET['students'];

$patern = '/(.*), (.*), (\w+), (\d+)/';
preg_match_all($patern, $students, $matches, PREG_PATTERN_ORDER);

$theOrder = $order == "ascending" ? SORT_ASC : SORT_DESC;

$names = $matches[1];
$emails = $matches[2];
$types = $matches[3];
$results = $matches[4];
$ids = array_keys($names);
$ids = array_map('incrementValue', $ids);

$fullArray = array($ids, $names, $emails, $types, $results);

if ($column == "id") {
    array_multisort($fullArray[0], $theOrder, SORT_NUMERIC, $fullArray[1], $fullArray[2], $fullArray[3], $fullArray[4]);
} else if ($column == "username") {
    array_multisort($fullArray[1], $theOrder, SORT_STRING, $fullArray[0], $theOrder, SORT_NUMERIC, $fullArray[2], $fullArray[3], $fullArray[4]);
} else {
    //sort by result
    array_multisort($fullArray[4], $theOrder, SORT_NUMERIC, $fullArray[0], $theOrder, SORT_NUMERIC, $fullArray[1], $fullArray[2], $fullArray[3]);
}
//print table
echo '<table>';
echo '<thead><tr><th>Id</th><th>Username</th><th>Email</th><th>Type</th><th>Result</th></tr></thead>';
for ($i = 0; $i < count($fullArray[0]); $i++) {
    echo'<tr>';
    for ($j = 0; $j < 5; $j++) {
        echo '<td>' . htmlspecialchars($fullArray[$j][$i]) . '</td>';
    }
    echo'</tr>';
}
echo '</table>';
//.....functions........................................................
function incrementValue($value) {
    return $value + 1;
}

?>