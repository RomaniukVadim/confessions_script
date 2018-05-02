<?php
/**
* Confessions
*
* @package Confessions
* @author LeoCoding
* @copyright 2017
* @terms any use of this script without a legal license is prohibited
* all the content of Confessions is the propriety of LeoCoding and Cannot be
* used for another project.
*/

if (file_exists('../config.php')) {
    header("Location: ../index.php");
    exit;
}

//get db input

$dbname = str_replace(' ', '', $_POST["dbname"]);
$dbuser = str_replace(' ', '', $_POST["dbuser"]);
$dbpass = $_POST["dbpass"];
$host = str_replace(' ', '', $_POST["host"]);

if (!empty($dbname) && !empty($dbuser) && !empty($dbpass) && !empty($host)) {
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        $die = "<p class='error'>Connection failed and rumor has it: " . $conn->connect_error . "</p>";
    } else {
        $tbl1 = $conn->query('select 1 from `confessions` LIMIT 1');
        $tbl2 = $conn->query('select 1 from `comments` LIMIT 1');

        if ($tbl1 !== false && $tbl2 !== false) {
            $exists = "<p class='info'>Database is already installed</p>";
        } else {
            $sql = "CREATE TABLE `confessions` (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `message` TEXT,
            `votesUp` varchar(30) NOT NULL,
            `votesDown` varchar(30) NOT NULL,
            `status` int(11) COLLATE utf8_unicode_ci NOT NULL,
            `time` TEXT,
            `ip` char(15) NOT NULL,
            PRIMARY KEY (`ID`)
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
            $result = $conn->query($sql);
            if ($result && !empty($result)) {
                $results .= "<p class='success'>Table <i>confessions</i> created</p>";
            } else {
                $results .= "<p class='error'>Can't create table <i>confessions</i> and rumor has it: " . $conn->error . "</p>";
            }

            $sql = "CREATE TABLE `comments` (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `conf_id` int(11) NOT NULL,   
            `message` TEXT,
            `votesUp` varchar(30) NOT NULL,
            `votesDown` varchar(30) NOT NULL,
            `status` int(11) COLLATE utf8_unicode_ci NOT NULL,
            `time` TEXT,
            `ip` char(15) NOT NULL,
            PRIMARY KEY (`ID`)
            )  ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
            $result = $conn->query($sql);
            if ($result && !empty($result)) {
                $results .= "<p class='success'>Table <i>comments</i> created</p>";
            } else {
                $results .= "<p class='error'>Can't create table <i>comments</i> and rumor has it: " . $conn->error . "</p>";
            }

            $myfile = "config.php";
            $txt = "<?php

return (object) array(
    'host' => '".$host."',
    'username' => '".$dbuser."',
    'pass' => '".$dbpass."',
    'database' => '".$dbname."'
    );
";
            $crconf = file_put_contents("../".$myfile, $txt);

            if ($crconf === false) {
                $esc_conf = htmlspecialchars($txt, ENT_QUOTES, 'UTF-8');
                $confstatus = "<p class='error'>We couldn't create config.php file, please create config.php in root of script with this content: <pre>".$esc_conf."</pre></p>";
            } else {
                $confstatus = "<p class='success'>Config file created</p>";
            }
        }

        $conn->close();
    }
}
?>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Confessions | Installer</title>
</head>
<body>

<div class="center">
<h1>Confessions v1.6 Installer</h1>
<form action="install.php" method="post">
<ul class="form-style-1">
<li>
<label>Database name <span class="required">*</span></label>
<input type="text" placeholder="DB_name" name="dbname" <?php echo isset($dbname) ? "value='".$dbname."'" : ''; ?>>
</li>

<li>
<label>Database username <span class="required">*</span></label>
<input type="text" placeholder="DB_username" name="dbuser" <?php echo isset($dbuser) ? "value='".$dbuser."'" : ''; ?>>
</li>

<li>
<label>Database password <span class="required">*</span></label>
<input type="password" placeholder="DBpassword" name="dbpass">
</li>

<li>
<label>Database host <span class="required">*</span></label>
<input type="text" placeholder="localhost" name="host" <?php echo isset($host) ? "value='".$host."'" : ''; ?>>
</li>

<li>
<input type="submit" value="Start Installation">
</li>
</ul>
</form>

<br />

<?php
echo isset($exists) ? $exists : '';
echo isset($die) ? $die : '';
echo isset($results) ? $results : '';
echo isset($confstatus) ? $confstatus : '';
?>
</div>


</body>
</html>