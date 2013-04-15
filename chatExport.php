
<?php

header('Content-Disposition: attachment; filename="chatHistory.html"');

$timestamp = time();
$datum = date("d.m.Y",$timestamp);

if (isset($_REQUEST['chatHistory'])) {
    $chatHistory = $_REQUEST['chatHistory'];
}
else
    $chatHistory = 'Error in generating chat history. Sorry!';

echo $datum . '<br>' . $chatHistory;
?>
