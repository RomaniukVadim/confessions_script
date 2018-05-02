<?php
/* Strings File */

//Navbar
$messages['home'] = 'Home';
$messages['title'] = 'Confessions';
$messages['confess'] = 'Confess';
$messages['confess-btn'] = 'Leave Confession';
//home page AKA index.php
$messages['h2title'] = 'Confessions';
//confess page AKA confess.php
$messages['h2title-confess'] = 'Confess your deepest secrets';
$messages['charleft'] = '1000 characters left';
$messages['confsent'] = 'Your Confession has been sent';
$messages['confshort'] = 'Your Confession is too short';
$messages['conflimit'] = 'You can post only one confession per day';
$messages['conferror'] = 'Something bad happened, please try again later';
$messages['conftextholder'] = 'Leave your confession here..';
//Single confession AKA confession.php
$messages['confession'] = 'Confession';
$messages['commentsent'] = 'Your Comment has been sent';
$messages['commshort'] = 'Your Comment is too short';
$messages['commtextholder'] = 'Leave your comment here..';

//Title tags

$messages['hometitle'] = 'Deepest and darkest secrets | Confessions';
$messages['confesstitle'] = 'Confess your sins | Confessions';
$messages['confessiontitle'] = 'Confession #'.(empty($_GET['id']) ? 'undefined' : str_replace(array('+','-'), '', filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_FLOAT))).' | Confessions';
