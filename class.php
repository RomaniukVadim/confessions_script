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

namespace Includes;

use mysqli;

class Methods
{

    /*
    timeAgo() function by codeforgeek.com 
    https://codeforgeek.com/2014/10/time-ago-implementation-php 
    */
    protected function timeAgo($ptime)
    {

        $estimate_time = time() - $ptime;

        if ($estimate_time < 1) {
            return 'less than 1 second ago';
        }

        $condition = array(
            12 * 30 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hour',
            60                      =>  'minute',
            1                       =>  'second'
            );

        foreach ($condition as $secs => $str) {
            $d = $estimate_time / $secs;

            if ($d >= 1) {
                $r = round( $d );
                return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
            }
        }
    }

    protected function convertYoutube($string)
    {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
    //"<a href='#' class='videopop'><img class='pop-inner' alt='$2' src='https://img.youtube.com/vi/$2/hqdefault.jpg'></img></a>",
            "<div class='embed-responsive embed-responsive-16by9'><iframe id='youtube' class='embed-responsive-item' src='//www.youtube.com/embed/$2' allowfullscreen></iframe></div>",
            $string
            );
    }

    protected function filterSmilies($text)
    {
        $smilies = array(
            ';)' => '<img src="assets/img/smileys/wink.png" />',
            ';-)' => '<img src="assets/img/smileys/wink.png" />',
            ':)' => '<img src="assets/img/smileys/smile.png" />',
            ':-)' => '<img src="assets/img/smileys/smile.png" />',
            ':))' => '<img src="assets/img/smileys/smile-big.png" />',
            ':D' => '<img src="assets/img/smileys/grin.png" />',
            ':-(' => '<img src="assets/img/smileys/frown.png" />',
            ':(' => '<img src="assets/img/smileys/frown.png" />',
            ':-((' => '<img src="assets/img/smileys/frown-big.png" />',
            ':-|' => '<img src="assets/img/smileys/neutral.png" />',
            ':-*' => '<img src="assets/img/smileys/kiss.png" />',
            ':-P' => '<img src="assets/img/smileys/razz.png" />',
            ':chic:' => '<img src="assets/img/smileys/chic.png" />',
            '8-)' => '<img src="assets/img/smileys/cool.png" />',
            ':-X' => '<img src="assets/img/smileys/angry.png" />',
            ':angry:' => '<img src="assets/img/smileys/really-angry.png" />',
            ':-?' => '<img src="assets/img/smileys/confused.png" />',
            '?:-)' => '<img src="assets/img/smileys/question.png" />',
            ':-/' => '<img src="assets/img/smileys/thinking.png" />',
            ':angel:' => '<img src="assets/img/smileys/angel.png" />',
            ':alien:' => '<img src="assets/img/smileys/alien.png" />',
            ':pain:' => '<img src="assets/img/smileys/pain.png" />',
            ':shock:' => '<img src="assets/img/smileys/shock.png" />',
            ':arrogant:' => '<img src="assets/img/smileys/arrogant.png" />',
            ':beatup:' => '<img src="assets/img/smileys/beat-up.png" />',
            ':yes:' => '<img src="assets/img/smileys/thumbs-up.png" />',
            ':no:' => '<img src="assets/img/smileys/thumbs-down.png" />',
            ':heart:' => '<img src="assets/img/smileys/heart.png" />',
            ':heartbroken:' => '<img src="assets/img/smileys/heart-broken.png" />',
            ':airplane:' => '<img src="assets/img/smileys/airplane.png" />',
            ':announce:' => '<img src="assets/img/smileys/announce.png" />',

            );

        return str_replace( array_keys( $smilies ), array_values( $smilies ), $text );
    }

    protected function sanitizeNumber($digit)
    {
        return str_replace(array('+','-'), '', filter_var($digit, FILTER_SANITIZE_NUMBER_FLOAT));
    }
}

class Database extends Methods
{
    protected $configs;
    protected $db;

    public function __construct()
    {
        $this->configs = include("../config.php");
        $this->db = new mysqli($this->configs->host, $this->configs->username, $this->configs->pass, $this->configs->database);

        if ($this->db->connect_errno > 0) {
            die('Unable to connect to database [' . $this->db->connect_error . ']');
        }
    }

    public function insert_confession($confession_body, $ip)
    {

        $this->confession = $confession_body;
        $this->time = time();
        $this->ip = $ip;

        $this->sql = $this->db->prepare("INSERT INTO confessions (message, time, ip) VALUES (?,?,?)");
        $this->sql->bind_param('sis', $this->confession, $this->time, $this->ip);

        if (!$result = $this->sql->execute()) {
            die('Execute Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        } else {
            header('Content-Type: application/json');
            $arr = array("status"=>'ok');
            echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function insert_comment($comment_body, $ip, $conf_id)
    {

        $this->comment = $comment_body;
        $this->time = time();
        $this->ip = $ip;
        $this->confid = $this->sanitizeNumber($conf_id);

        $this->sql = $this->db->prepare("INSERT INTO comments (message, time, ip, conf_id) VALUES (?,?,?,?)");
        $this->sql->bind_param('sisi', $this->comment, $this->time, $this->ip, $this->confid);

        if (!$result = $this->sql->execute()) {
            die('Execute Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        } else {
            header('Content-Type: application/json');
            $arr = array("status"=>'ok');
            echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    private function comments_number($conf_id)
    {
        $this->sql = $this->db->prepare("SELECT * FROM comments WHERE conf_id=?");
        $this->confid = $this->sanitizeNumber($conf_id);
        $this->sql->bind_param('i', $this->confid);

        $this->sql->execute();

        if (!$result = $this->sql->get_result()) {
            die('Getting Result Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        }

        return $result->num_rows;
    }

    public function get_confessions($value)
    {
        $this->value_cl = $this->sanitizeNumber($value);

        if ($this->value_cl==='0') {
            $this->sql = $this->db->prepare("SELECT * FROM confessions ORDER BY ID desc LIMIT 0,4");
        } else {
            $this->sql = $this->db->prepare("SELECT * FROM confessions WHERE ID < ? ORDER BY ID desc LIMIT 0,4");
            $this->sql->bind_param('i', $this->value_cl);
        }

        $this->sql->execute();

        if (!$result = $this->sql->get_result()) {
            die('Getting Result Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        }

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        if (is_array($rows) || is_object($row)) {
            $result = array();
            foreach ($rows as $row) {
                $nowtime = $this->timeAgo($row['time']);
                $conf_msg = $this->convertYoutube(htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8'));
                $comm_num = $this->comments_number($row['ID']);

                $arr = array("conf_id"=>$row['ID'], "conf_msg"=>$this->filterSmilies($conf_msg), "votesUp"=>$row['votesUp'], "votesDown"=>$row['votesDown'], "comments"=>$comm_num, "time"=>$nowtime);
                array_push($result, $arr);
            }
            header('Content-Type: application/json');
            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo "[]";
        }
    }

    public function get_comments($conf_id)
    {
        $this->confid = $this->sanitizeNumber($conf_id);

        $this->sql = $this->db->prepare("SELECT * FROM comments WHERE conf_id = ? ORDER BY ID desc");
        $this->sql->bind_param('i', $this->confid);

        $this->sql->execute();

        if (!$result = $this->sql->get_result()) {
            die('Getting Result Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        }

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        if (is_array($rows) || is_object($row)) {
            $result = array();
            foreach ($rows as $row) {
                $nowtime = $this->timeAgo($row['time']);
                $comm_msg = htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8');

                $arr = array("comm_id"=>$row['ID'], "comm_msg"=>$this->filterSmilies($comm_msg), "votesUp"=>$row['votesUp'], "votesDown"=>$row['votesDown'], "time"=>$nowtime);
                array_push($result, $arr);
            }
            header('Content-Type: application/json');
            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo "[]";
        }
    }

    public function get_single_confession($id)
    {
        $this->confid = $this->sanitizeNumber($id);

        $this->sql = $this->db->prepare("SELECT * FROM confessions WHERE ID = ?");
        $this->sql->bind_param('i', $this->confid);

        $this->sql->execute();

        if (!$result = $this->sql->get_result()) {
            die('Getting Result Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        }

        $row = $result->fetch_assoc();

        if ($row!=false) {
            $nowtime = $this->timeAgo($row['time']);
            $conf_msg = $this->convertYoutube(htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8'));

            $arr = array("conf_id"=>$row['ID'], "conf_msg"=>$this->filterSmilies($conf_msg), "votesUp"=>$row['votesUp'], "votesDown"=>$row['votesDown'], "time"=>$nowtime);

            header('Content-Type: application/json');
            echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo "[]";
        }
    }

    public function voteUp($id)
    {
        $this->confid = $this->sanitizeNumber($id);

        $this->sql = $this->db->prepare("UPDATE confessions SET votesUp = votesUp + 1 WHERE ID = ?");
        $this->sql->bind_param('i', $this->confid);

        if (!$result = $this->sql->execute()) {
            die('Execute Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        } else {
            header('Content-Type: application/json');
            $arr = array("status"=>'ok');
            echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function comm_voteUp($conf_id, $comm_id)
    {
        $this->confid = $this->sanitizeNumber($conf_id);
        $this->commid = $this->sanitizeNumber($comm_id);

        $clean_comm_id = $this->sanitizeNumber($clean_comm_id);

        $this->sql = $this->db->prepare("UPDATE comments SET votesUp = votesUp + 1 WHERE conf_id = ? AND ID = ?");
        $this->sql->bind_param('ii', $this->confid, $this->commid);

        if (!$result = $this->sql->execute()) {
            die('Execute Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        } else {
            header('Content-Type: application/json');
            $arr = array("status"=>'ok');
            echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function voteDown($id)
    {
        $this->conf_id = $this->sanitizeNumber($id);

        $this->sql = $this->db->prepare("UPDATE confessions SET votesDown = votesDown + 1 WHERE ID = ?");
        $this->sql->bind_param('i', $this->conf_id);

        if (!$result = $this->sql->execute()) {
            die('Execute Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        } else {
            header('Content-Type: application/json');
            $arr = array("status"=>'ok');
            echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function comm_voteDown($conf_id, $comm_id)
    {
        $this->confid = $this->sanitizeNumber($conf_id);
        $this->commid = $this->sanitizeNumber($comm_id);

        $this->sql = $this->db->prepare("UPDATE comments SET votesDown = votesDown + 1 WHERE conf_id = ? AND ID = ?");
        $this->sql->bind_param('ii', $this->confid, $this->commid);

        if (!$result = $this->sql->execute()) {
            die('Execute Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        } else {
            header('Content-Type: application/json');
            $arr = array("status"=>'ok');
            echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function limit_check($ip)
    {
        $this->time = time() - 24 * 60 * 60 ;

        $this->sql = $this->db->prepare("SELECT * FROM confessions WHERE ip = ? AND time > ?");
        $this->sql->bind_param('si', $ip, $this->time);

        $this->sql->execute();

        if (!$result = $this->sql->get_result()) {
            die('Getting Result Error: (' . $this->sql->errno . ') ' . $this->sql->error);
        } else {
            return $result->num_rows;
        }
    }
}
