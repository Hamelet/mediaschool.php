<?php


require "db.php";

// first line of PHP
$defaultTimeZone='UTC';
if(date_default_timezone_get()!=$defaultTimeZone) date_default_timezone_set($defaultTimeZone);

// somewhere in the code
function _date($format="r", $timestamp=false, $timezone=false)
{
    $userTimezone = new DateTimeZone(!empty($timezone) ? $timezone : 'GMT');
    $gmtTimezone = new DateTimeZone('GMT');
    $myDateTime = new DateTime(($timestamp!=false?date("r",(int)$timestamp):date("r")), $gmtTimezone);
    $offset = $userTimezone->getOffset($myDateTime);
    return date($format, ($timestamp!=false?(int)$timestamp:$myDateTime->format('U')) + $offset);
}

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);  



if (isset($_POST['formRedaction'])) {
    
    if (!empty($_POST['title']) AND !empty($_POST['content'])) {
        $author = $_SESSION['id'];
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $insertMessage = $conn->prepare("INSERT INTO messages(user_id, title, texte) VALUES (?, ?, ?)");
        $insertMessage->execute(array($author, $title, $content));
        header("Location: index.php?id=" . $_SESSION['id']);

    }
    else
    {
    $erreur = "Une erreur est survenue !";
    }
}


