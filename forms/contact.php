<?php
ob_start();
if (
    empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['contactno'])
) {
    die('Cannot proceed with empty inputs. Goback and retry');
}

$client_email = 'priencekumar09@gmail.com';
$project_name = 'test leads';

$name = htmlentities($_REQUEST['name']);
$email = htmlentities($_REQUEST['email']);
$contactno = htmlentities($_REQUEST['contactno']);
$site_referrer = isset($_POST['site_referrer'])
    ? $_POST['site_referrer']
    : 'direct';
$cid = $_POST['cid'] ?? '';

// var_dump($name, $email, $contactno, $site_referrer, $cid);
// Google Sheet Integration - START
require 'php-google-sheet/index.php';
sendtoSheet('first sheet', $name, $email, $contactno, $site_referrer);
// Google Sheet Integration - END

 header("Location:/thankyou.html");
 ob_end_flush();
?>
