<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Database Library
 * - Sequel Action
 * - Sanitize
 * - Encryption
 *
 * @since 2019
 * @version 3.0
 * @author Ebiz Developers
 */
class Yel {

    private $db; // * Query to perform
    private $query;  //query holder
    private $result; // Result holds data retrieved from server
    private $num_rows; // store the nos of rows in a result

    public function __construct() {

        // php config
        ini_set('memory_limit', '-1');

        // connect to database
        $this->con();
    }

    /**
     * Connect to Database with parameters
     */
    function con() {
        try {
            set_error_handler(array($this, 'errHandler'));
            $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASSWORD, array(
                PDO::ATTR_PERSISTENT => true,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
            restore_error_handler();
            $this->state = true;

            if ($this->db === null) {
                echo "error";
            }
        } catch (PDOException $e) {
            // die('Please contact Yel . Thank you. #ERROR [ 404 ] ');
            echo 'Connection Failed: ' . $e->getMessage();
        }
    }

    /**
     * Error Handler
     *
     * @param type $errno
     * @param type $errstr
     */
    public function errHandler($errno, $errstr) {
        // echo 'Error found';
    }

    /**
     * Sleep Database Process
     *
     * @return array
     */
    public function __sleep() {
        return array('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    }

    /**
     * Reconnect Database Process
     *
     * @return array
     */
    public function __wakeup() {
        $this->con();
    }

    /**
     * Connect Database
     */
    function connect() {
        if ($this->db == null) {
            $this->con();
        }
    }

    /**
     * Disconnect from database
     */
    function disconnect() {
        if ($this->db != null) {
            $this->db = null;
            unset($this->db);
        }
    }

    /**
     * Sanitize [ Strip HTML Tags ]
     *
     * @param mixed $value
     * @return mixed
     */
    public function strip_html_tags($value) {
        $value = preg_replace(
                array(
                    // Remove invisible content
                    '@<head[^>]*?>.*?</head>@siu',
                    '@<style[^>]*?>.*?</style>@siu',
                    '@<script[^>]*?.*?</script>@siu',
                    '@<object[^>]*?.*?</object>@siu',
                    '@<embed[^>]*?.*?</embed>@siu',
                    '@<applet[^>]*?.*?</applet>@siu',
                    '@<noframes[^>]*?.*?</noframes>@siu',
                    '@<noscript[^>]*?.*?</noscript>@siu',
                    '@<noembed[^>]*?.*?</noembed>@siu'
                ), array(
            '', '', '', '', '', '', '', '', ''), $value);

        return strip_tags($value);
    }

    /**
     * Sanitize [ Fix page ]
     *
     * @param mixed $value
     * @return mixed
     */
    public function fix_page($value) {
        $value = htmlspecialchars(trim($value));
        //if (get_magic_quotes_gpc())
            $value = stripslashes($value);
        return $value;
    }

    public function removeslashes($string) {
        $string = implode("", explode("\\", $string));
        return stripslashes(trim($string));
    }

    /**
     * Fix Encoding as htmlentities
     *
     * @param array $value
     * @return array $value
     */
    public function fix_html_entities($value) {

        array_walk_recursive($value, function(&$item) {
            $item = htmlentities($item);
        });
        return $value;
    }

    /**
     * Sanittize [ Fix Mysql Sequel ]
     *
     * @param mixed $value
     * @return mixed
     */
    public function fix_mysql($value) {
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        //  $value = $this->db->real_escape_string(trim($value));
        return $value;
    }

    /**
     * Generate Transaction Key
     *
     * @param string $value
     * return mixed
     */
    public function transaction_key($sValue) {
        $sValue = strtoupper(substr(sha1(md5(sha1(BASE_SALT) . sha1($sValue))), 2, 22));
        return $sValue;
    }

    /**
     * Generate Document Key
     *
     * @param int $value
     * return mixed
     */
    public function document_key($iLength = 22) {
        $sValue = substr(sha1(md5(sha1(BASE_SALT) . sha1(uniqid()))), 1, $iLength);
        return $sValue;
    }

    /**
     * Sanitize [ Clean ]
     *
     * @param mixed $value
     * @return mixed
     */
    public function clean($value) {
        $value = $this->strip_html_tags($value);
        $value = $this->fix_page($value);
        $bad = array("=", "<", ">", "/", "\"", "`", "~", "'", "$", "%", "#", "?", ".exe", "DROP", "DELETE", "SLEEP(", "truncate", "Truncate", "TRUNCATE");
        $value = str_ireplace($bad, "", $value);
        // $value = $this->fix_mysql($value);
        return $value;
    }

    /**
     * Sanitize [ Deep Clean ]
     *
     * @param mixed $value
     * @return mixed
     */
    public function cln($value) {
        if (!empty($value)) {
            $value = $this->fix_page($value);
            $value = $this->strip_html_tags($value);
            $bad1 = array("=", "/", "\"", "`", "~", "'", "$", "%", "#", "?", "+"); // acceptable string
            foreach ($bad1 as $a) {
                $value = str_replace($a, "\\" . $a, $value);
            }
            $input = strtolower($value);
            $bad2 = array(";", "<", ">", ".exe", ".sh", "drop", "delete", "truncate",); // prohibited string
            foreach ($bad2 as $b) {
                if (strpos($input, $b) !== false) {
                    $flag = true;
                    break;
                }
            } if ($flag == true) {
                $value = '';
            }
        } else {
            $value = '';
        }
        return $value;
    }

    /**
     * Clean [ Soft Clean ]
     *
     * @param mixed $value
     * @return mixed
     */
    public function clean_minor($value) {
        $value = $this->strip_html_tags($value);
        $value = $this->fix_page($value);
        $bad = array("=", "<s", "'", "$", "%", "?", ".exe", "DROP", "drop", "Drop", "DELETE", "Delete", "delete");
        $value = str_replace($bad, "", $value);
        //$value = $this->fix_mysql($value);
        return $value;
    }

    /**
     * Clean Array [ Soft Clean for an Array ]
     *
     * @param array $aValue
     * @param array $aExcept
     * @return array $aNewValue
     */
    public function clean_array($aValue, $aExcept = null) {
        $aNewValue = array();

        if (is_array($aValue) === true && sizeof($aValue) > 0) {

            foreach ($aValue as $key => $val) {

                if (is_array($aExcept) !== false) {

                    if (sizeof($aExcept) > 0) {
                        if (in_array($key, $aExcept) === true) {
                            $aNewValue = array_merge($aNewValue, array($this->clean($key) => $this->clean_minor($val)));
                        } else {
                            $aNewValue = array_merge($aNewValue, array($this->clean($key) => $this->clean($val)));
                        }
                    } else {
                        $aNewValue = array_merge($aNewValue, array($this->clean($key) => $this->clean($val)));
                    }
                } else {
                    $aNewValue = array_merge($aNewValue, array($this->clean($key) => $this->clean($val)));
                }
            }
        }

        return $aNewValue;
    }

    /**
     * Safe mode clean [ Single ]
     *
     * @param string $value
     * @return mixed $value
     */
    public function safe_mode_clean($value) {
        $value = addslashes($value);
        $value = preg_replace(
                array(
                    // Remove invisible content
                    '@<head[^>]*?>.*?</head>@siu',
                    '@<style[^>]*?>.*?</style>@siu',
                    '@<script[^>]*?.*?</script>@siu',
                    '@<object[^>]*?.*?</object>@siu',
                    '@<embed[^>]*?.*?</embed>@siu',
                    '@<applet[^>]*?.*?</applet>@siu',
                    '@<noframes[^>]*?.*?</noframes>@siu',
                    '@<noscript[^>]*?.*?</noscript>@siu',
                    '@<noembed[^>]*?.*?</noembed>@siu'
                ), array(
            '', '', '', '', '', '', '', '', ''), $value);


        return $value;
    }

    /**
     * Safe Mode Clean Array [Multiple]
     *
     * @param array $aValue
     * @param array $aExcept
     * @return array $aValue
     */
    public function safe_mode_clean_array($aValue, $aExcept = null) {
        $aNewValue = array();

        if (is_array($aValue) === true && sizeof($aValue) > 0) {

            foreach ($aValue as $key => $val) {

                if (is_array($aExcept) !== false) {

                    if (sizeof($aExcept) > 0) {
                        if (in_array($key, $aExcept) === true) {
                            $aNewValue = array_merge($aNewValue, array($this->clean($key) => $this->clean_minor($val)));
                        } else {
                            $aNewValue = array_merge($aNewValue, array($this->clean($key) => $this->safe_mode_clean($val)));
                        }
                    } else {
                        $aNewValue = array_merge($aNewValue, array($this->clean($key) => $this->safe_mode_clean($val)));
                    }
                } else {
                    $aNewValue = array_merge($aNewValue, array($this->clean($key) => $this->safe_mode_clean($val)));
                }
            }
        } else if (is_string($aValue) === true) {
            $aNewValue = null;
            $aNewValue = $this->safe_mode_clean($aValue);
        }

        return $aNewValue;
    }

    /**
     * Safe mode clean Array Walk Recursive [ Soft Clean for an Array ] w/ utf8
     *
     * @param array $aValue
     * @param array $aExcept
     * @return array $aNewValue
     */
    public function safe_mode_clean_array_walk_recursive($aNewValue) {
        array_walk_recursive($aNewValue, function(&$item) {
            $item = $this->safe_mode_clean_array(utf8_encode($item));
        });

        return $aNewValue;
    }

    /**
     * Clean Array Walk Recursive [ Soft Clean for an Array ] w/ utf8
     *
     * @param array $aValue
     * @param array $aExcept
     * @return array $aNewValue
     */
    public function clean_array_walk_recursive($aNewValue) {
        array_walk_recursive($aNewValue, function(&$item) {
            $item = $this->clean_minor(utf8_encode($item));
        });

        return $aNewValue;
    }

    /**
     * Clean Array Recursive [ Soft Clean for an Array ]
     *
     * @param array $aValue
     * @param array $aExcept
     * @return array $aNewValue
     */
    public function clean_array_recursive($aNewValue) {

        if (is_array($aNewValue) !== false) {
            array_walk_recursive($aNewValue, function(&$item) {
                $item = $this->clean($item);
            });

            return $aNewValue;
        } else {
            return $this->clean_array($aNewValue);
        }
    }

    /**
     * Fetch one rows in a result and store it as  array
     *
     * @param string $sql
     * @return string
     */
    public function query($sql) {
        if (!empty($sql)) {
            $this->connect(); //connect to database
            try {
                // $this->vlookup($sql);
                $q = $this->db->prepare($sql);
                $q->execute();
                $q->setFetchMode(PDO::FETCH_ASSOC);
                $data = $q->fetchAll();

                return $data;
                //echo json_encode($data);
                $this->disconnect(); //disconnect from database
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return 'No query provided';
            die;
        }
    }

    /**
     * Execute Sequel
     *
     * @param string $sql
     * @param string $foradmin
     * @return boolean|string
     */
    public function exec($sql, $foradmin = false) {
        if (!empty($sql)) {
            $this->connect(); //connect to database
            try {
                if (!$this->checkrestrictedwords($sql) || $foradmin || stristr($sql, 'sessionlogs')) {
                    // $this->vlookup($sql);
                    $q = $this->db->prepare($sql);
                    $q->execute();
                    if ($q->errorInfo()[0] == 0000) {
                        return array('stat' => $q->rowCount(), 'msg' => "Success :: " . $q->rowCount() . " as Affected rows.", 'insert_id' => $this->db->lastInsertId());
                    } else {
                        return "Error # : " . $q->errorInfo()[0] . " :: " . $q->errorInfo()[1] . "<br/>" . "Message :" . $q->errorInfo()[2];
                    }
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return 'No query provided';
            die;
        }
        $this->disconnect(); //disconnect from database
    }

    /**
     *
     * Execute Sequel
     * @param string $sql
     * @return string
     */
    public function exc($sql) {
        if (!empty($sql)) {
            $this->connect(); //connect to database
            try {
                $q = $this->db->prepare($sql);
                $q->execute();
                if ($q->errorInfo()[0] == 0000) {
                    return array('stat' => $q->rowCount(), 'msg' => "Success :: " . $q->rowCount() . " as Affected rows.", 'insert_id' => $this->db->lastInsertId());
                } else {
                    return "Error # : " . $q->errorInfo()[0] . " :: " . $q->errorInfo()[1] . "<br/>" . "Message :" . $q->errorInfo()[2];
                }
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return 'No query provided';
            die;
        }
        $this->disconnect(); //disconnect from database
    }

    /**
     * Fetch one column
     *
     * @param string $sql
     * @return string
     */
    public function GetOne($sql) {
        $this->connect(); //connect to database
        if (!empty($sql)) {
            try {
                $re = $this->db->prepare($sql);
                $re->execute();
                return $re->fetchColumn();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return 'No query provided';
            die;
        }
        $this->disconnect(); //disconnect from database
    }

    /**
     * fetch one rows in a result and store it as an  object
     *
     * @param string $sql
     * @return string
     */
    public function GetRow($sql) {
        if (!empty($sql)) {
            $this->connect(); //connect to database
            try {
                //	$this->vlookup($sql);
                //	$sql = str_replace("LIKE","=",$sql);
                $q = $this->db->prepare($sql);
                $q->execute();
                return (array) $q->fetch(PDO::FETCH_OBJ);
                $this->disconnect(); //disconnect from database
            } catch (PDOException $e) {
                return $e->getMessage();
            }
            $this->disconnect(); //disconnect from database
        } else {
            return 'No query provided';
            die;
        }
    }

    /**
     * Fetch all rows in a result to assoc_array
     *
     * @param string $sql
     * @return string
     */
    public function GetAll($sql) {
        if (!empty($sql)) {
            $this->connect(); //connect to database
            try {
                $q = $this->db->prepare($sql);
                $q->execute();
                $q->setFetchMode(PDO::FETCH_ASSOC);
                $data = $q->fetchAll();

                return $data;
                //echo json_encode($data);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
            $this->disconnect(); //disconnect from database
        } else {
            return 'No query provided';
            die;
        }
    }

    /**
     * Fetch one rows in a result and store it as an  object
     *
     * @param string $sql
     * @return string
     */
    public function GetRowObject($sql) {

        if (!empty($sql)) {
            $this->connect(); //connect to database
            try {
                $q = $this->db->prepare($sql);
                $q->execute();
                return $q->fetch(PDO::FETCH_OBJ);
                $this->disconnect(); //disconnect from database
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return 'No query provided';
            die;
        }
    }

    /**
     * Get Max Value / ID
     * Hence, id should be present
     *
     * @param string $sTableName
     * @param string $sFieldName
     */
    public function GetMax($sTableName, $sFieldName) {

        if (!empty($sTableName) === true && !empty($sFieldName) === true) {

            // perform to get the latest id
            $iId = $this->query("
                SELECT
                    MAX(`" . $sFieldName . "`) as ID
                FROM
                `" . $sTableName . "`
                ");
            return $iId;
        } else {
            return 'No parameter provided';
            die;
        }
    }

    /**
     * Get Record Value / ID
     * Hence, id should be present
     *
     * @param string $sTableName
     * @param string $sFieldName
     * @param array $aWildCard
     */
    public function GetRecordByID($sTableName, $sFieldName, $aWildCard) {

        if (!empty($sTableName) === true && !empty($sFieldName) === true && is_array($aWildCard) === true) {

            // perform to get the selected record
            $sAddSQL = ' WHERE ';
            foreach ($aWildCard as $key => $val) {
                $sAddSQL .= " `" . $key . "` = '" . $val . "' AND";
            }
            $sAddSQL = rtrim($sAddSQL, "AND");

            $sResponse = $this->GetOne("
                SELECT
                   `" . $sFieldName . "` as `record_set`
                FROM
                `" . $sTableName . "`
                   " . $sAddSQL . " 
                LIMIT 1
                ");
            return $sResponse;
        } else {
            return 'No parameter provided';
            die;
        }
    }

    /**
     * Fetch one rows in a result and store it as  array
     *
     * @param string $sql
     * @return string
     */
    public function GetRowArray($sql) {
        $this->connect(); //connect to database
        if (!empty($sql)) {
            try {
                $q = $this->db->prepare($sql);
                $q->execute();
                return $q->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return 'No query provided';
            die;
        }
        $this->disconnect(); //disconnect from database
    }

    /**
     * Server Information
     *
     * @return type
     */
    public function server_info() /* print server version */ {
        $this->connect();
        return $this->connect->server_info;
        $this->disconnect();
    }

    /**
     * Delete Function
     *
     * @param string $tbl
     * @param string $id
     */
    function delete($tbl, $id) {
        $this->execute("delete from {$this->clean($tbl)} where id='{$this->clean($id)}'");
    }

    /**
     * Execute query supply
     *
     * @param string $sql
     * @param string $foradmin
     * @return boolean|string
     */
    public function execute($sql, $foradmin = false) {
        $this->connect(); //connect to database
        if (!empty($sql)) {
            $this->vlookup($sql);
            // var_dump($foradmin);
            if (!$this->checkrestrictedwords($sql) || $foradmin || stristr($sql, 'sessionlogs')) {
                $sth = $this->db->prepare($sql);
                return $sth->execute();
            } else {
                return false;
            }
            //return  $sth->fetchColumn();
        } else {
            return 'No query provided';
            die;
        }

        $this->disconnect(); //disconnect from database
    }

    /**
     * Check Restrict Ed Words
     *
     * @param string $sql
     * @return string
     */
    public function checkrestrictedwords($sql) {
        $sql = strtolower(preg_replace('/([^a-z-*A-Z])/', '', $sql));
        return (int) $this->GetOne(' SELECT COUNT(1) FROM `bad_words` WHERE "' . $sql . '" LIKE CONCAT("%",`badword`,"%") ');
    }

    /**
     * Check if column exists in the given database table
     *
     * @param string $tbl
     * @param string $col
     * @return string
     */
    public function checkcol($tbl, $col) {
        $this->connect(); //connect to database
        if (!empty($tbl)) {
            try {
                $sql = "SELECT count(*)
                FROM information_schema.COLUMNS
                WHERE
                TABLE_SCHEMA = '" . DB_NAME . "'
                AND TABLE_NAME = '" . $tbl . "'
                AND COLUMN_NAME = '" . $col . "'";

                return $this->GetOne($sql);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return 'No query provided';
            die;
        }
        $this->disconnect(); //disconnect from database
    }

    /**
     * Save Info
     *
     * @param string $tbl
     */
    function saveInfo($tbl) {
        $this->connect(); //connect to database
        $label = array();
        $value = array();
        $update = "";

        //create the table if not exist
        $tbl_col = null;
        foreach ($_POST as $f => $v) {
            $tbl_col .= $f . " varchar(255) not null,";
        }
        $tbl_col = substr($tbl_col, 0, -1);
        $sql_ = "create table if not exists {$tbl} ( id int auto_increment primary key,{$tbl_col},unique key tID(tID))";
        $this->execute($sql_);
        //echo $sql_;
        //end of table creation if not exists
        //process the given data
        foreach ($_POST as $key => $val) {
            $lb = $this->checkcol($tbl, $key);
            if ($lb > 0) {
                $label[$key] = $key;
                if ($key == "description" || $key == "valid" || $key == "link" || strstr($key, "dob") || $key == "custom" || $key == "detail" || $key == "billdue") { //
                    $value[$key] = $val;
                    $update .= $key . "='" . $val . "',";
                } elseif ($key == "password") {
                    //$pass = md5($this->strip_html_tags($_POST['username']).$this->strip_html_tags($_POST['password']));
                    $passwo = md5(md5($this->clean($_POST['username'])) . md5($this->clean($_POST['password'])));
                    $pass = md5($passwo . PASSWORD_SALT);


                    $value[$key] = $pass;
                    $update .= $key . "='" . $pass . "',";
                } else {
                    $value[$key] = $this->clean($val);
                    $update .= $key . "='" . $this->clean($val) . "',";
                }
            }
        }
        $update = substr($update, 0, -1); //remove the last comma
        //check if colum exist is table
        $cols = "";
        if (is_array($label)) {
            foreach ($label as $lbl) {
                $cols .= $lbl . ',';
            }
        }
        $cols = substr($cols, 0, -1); //remove the last comma


        $va = "";
        if (is_array($value)) {
            foreach ($value as $v) {
                $va .= "'" . $v . "',";
            }
        }
        $va = substr($va, 0, -1); //remove the last comma

        $sql = "";
        if (!empty($_POST['id'])) {
            $sql = "update {$tbl} set {$update} where id='{$this->clean($_POST['id'])}'";
        } else {
            $sql = "insert into {$tbl}({$cols}) values({$va})";
        }


        $this->execute($sql);
        //print_r($_POST);

        $this->disconnect(); //disconnect from database
    }

    /**
     * Get specific column from table
     *
     * @param string $col
     * @param tystringpe $sF
     * @param string $sV
     * @param string $tbl
     * @param string $cmd
     * @param string $other
     * @return string
     */
    function getField($col, $sF, $sV, $tbl, $cmd, $other = null) {
        return $this->$cmd("select
          {$this->clean($col)} from
          {$this->clean($tbl)} where
          {$this->clean($sF)}='{$this->clean($sV)}' {$other}");
    }

    /**
     * get specific column from table
     *
     * @param string$col
     * @param string $tbl
     * @param string $cmd
     * @param string $cond
     * @return string
     */
    function getTblInfo($col, $tbl, $cmd, $cond = null) {
        return $this->$cmd("select
          {$this->clean($col)} from
          {$this->clean($tbl)} {$cond}");
    }

    /**
     * Encryption Bank Number
     *
     * @param mixed $action
     * @param mixed $value
     * @return boolean
     */
    function crypt($action, $value) {

        if (isset($action) && isset($value)) {
            $value = str_split($value);
            if ($action == 'encrypt') {
                $rep = [1, 0, 9, 8, 7, 6, 5, 4, 3, 2];
                foreach ($value as $key => $val) {
                    $value[$key] = str_replace($val, $rep[$val], $val);
                }
            } else if ($action == 'decrypt') {
                $rep = [1 => 0, 0 => 1, 9 => 2, 8 => 3, 7 => 4, 6 => 5, 5 => 6, 4 => 7, 3 => 8, 2 => 9];
                foreach ($value as $key => $val) {
                    $value[$key] = str_replace($val, $rep[$val], $val);
                }
            }
            return implode($value);
        } else
            return false;
    }

    /**
     * Encryption for User Password | Deep
     *
     * @param string $sValue
     * @return string
     */
    public function deep_encypt($sValue) {

        // SALTING
        $sValue = substr(sha1(md5(sha1(BASE_SALT_DEEP) . sha1($sValue))), 2, 22);

        return $sValue;
    }

    /**
     * Password Encryption
     * with 3 level of encryption
     *
     * @param string $sValue
     * @return string $sValue
     */
    public function encrypt($sValue) {

        // replacer for invalid string
        $aInvalidParam = array('/', '+', "=");
        $aReplacer = array('Fs5X', 'PlxS', "3Q5l");

        // first level of encryption
        $sValue = openssl_encrypt($sValue, "AES-128-ECB", BASE_SALT);

        // second level of ecryption
        $sValue = openssl_encrypt($sValue, "AES-256-ECB", BASE_SALT_DEEP);

        // deep level of ecryption
        $sValue = openssl_encrypt($sValue, "AES-128-ECB", BASE_SALT);

        // clean mode
        $sValue = 'g' . str_replace($aInvalidParam, $aReplacer, $sValue);

        return $sValue;
    }

    /**
     * Password Decryption
     *
     * @param string $sValue
     * @return string $sValue
     */
    public function _decryptor($sValue) {

        $aRetriever = array('/', '+', '=');
        $aSalted = array('Fs5X', 'PlxS', '3Q5l');
        $sValue = str_replace($aSalted, $aRetriever, $sValue);
        $sValue = substr($sValue, 1);
        $sValue = openssl_decrypt($sValue, "AES-128-ECB", BASE_SALT);
        $sValue = openssl_decrypt($sValue, "AES-256-ECB", BASE_SALT_DEEP);
        $sValue = openssl_decrypt($sValue, "AES-128-ECB", BASE_SALT);

        return $sValue;
    }

    /**
     * Parameter Encryption
     * with 3 level of encryption
     *
     * @param string $sValue
     * @return string $sValue
     */
    public function encrypt_param($sValue) {

        // replacer for invalid string
        $aInvalidParam = array('/', '+', "=");
        $aReplacer = array('Fs5X', 'PlxS', "3Q5l");

        $sValue = openssl_encrypt($sValue, "AES-128-ECB", BASE_SALT);
        $sValue = openssl_encrypt($sValue, "AES-256-ECB", BASE_SALT_DEEP);
        $sValue = 'i' . str_replace($aInvalidParam, $aReplacer, $sValue);
        // $sValue = substr_replace('j' . $sValue, "", -1);

        return $sValue;
    }

    /**
     * Parameter Decryption
     *
     * @param string $sValue
     * @return string $sValue
     */
    public function decrypt_param($sValue) {

        $aRetriever = array('/', '+', '=');
        $aSalted = array('Fs5X', 'PlxS', '3Q5l');
        $sValue = str_replace($aSalted, $aRetriever, $sValue);
        $sValue = substr($sValue, 1);
        $sValue = openssl_decrypt($sValue, "AES-256-ECB", BASE_SALT_DEEP);
        $sValue = openssl_decrypt($sValue, "AES-128-ECB", BASE_SALT);

        return $sValue;
    }

    /**
     * Restore Semi Encoded String
     * 
     * @array string $sValue
     * @return string $sValue
     */
    public function stringDecoder($sValue) {

        $aRetriever = array(',', '&amp;', '#', '.', '-');
        $aSalted = array('y3lc', 'y3la', 'y3lh', 'y3ld', 'y2l');
        $sValue = str_replace($aSalted, $aRetriever, $sValue);
        return $sValue;
    }

    /**
     * String Encoding [ utf8_encode as default ]
     * PHP 5.4 and above | JSON Compability
     *
     * @param string|mixed $value
     * @param string $encoding
     * @return string|mixed
     */
    public function string_encoding($value, $encoding = 'utf8_encode') {

        // convert string encoding
        $value = $encoding($value);

        return $value;
    }

    /**
     * Convert all charset to utf8
     * jsonEncodeArray
     *
     * @param array $array
     * @return array $array
     */
    public function jsonEncodeArray($array) {
        array_walk_recursive($array, function(&$item) {
            $item = utf8_encode($item);
        });
        return $array;
    }

    /**
     * Pagination Build Simulator
     *
     * @param array $aParam
     * @return array $aParam
     */
    public function pagination($aParam) {

        // sanitize
        $aParam = $this->clean_array($aParam);

        // page
        $page = 1;
        if (!empty($aParam['page']) !== false) {
            $page = (int) $aParam['page'];
            if ($page <= 0) {
                $page = 1;
            }
        }

        // limit simulation
        $limit = 10;
        if (!empty($aParam['limit']) !== false) {
            $limit = $aParam['limit'];
            if ((int) $aParam['limit'] > 1000) {
                $limit = 10;
            }
        }

        $start = $limit * ($page - 1);
        $aParam['start'] = $start;
        $aParam['limit'] = $limit;
        $aParam['page'] = $page;

        return $aParam;
    }


    /**
     * Parameter Encryption
     * with 3 level of encryption
     *
     * @param string $aValue
     * @return string $aValue
     */
    public function encrypt_param_row($aRecordSet, $sColumnId)
    {

        if (is_array($sColumnId) !== false) {

            foreach ($sColumnId as $key => $val) {
                $aRecordSet[$val] = $this->encrypt_param($aRecordSet[$val]);
            }
        }

        return $aRecordSet;
    }

    /**
     * Encrypt ID in an Array
     *
     * @param array $aRecordSet ['descrypted']
     * @param array $sColumnId | $aColumnId
     * @return array $aRecordSet ['encrypted']
     */
    public function encrypt_id_in_array($aRecordSet, $sColumnId) {

        $x = 0;
        if (is_array($sColumnId) !== false) {
            // $iArrayCount = count($sColumnId);

            foreach ($aRecordSet as $key => $val) {
                $i = 0;
                foreach ($sColumnId as $k => $v) {
                    $aRecordSet[$x][$v] = $this->encrypt_param($val[$v]);
                    $i++;
                }
                $x++;
            }
        } else {

            foreach ($aRecordSet as $key => $val) {
                $aRecordSet[$x][$sColumnId] = $this->encrypt_param($val[$sColumnId]);
                $x++;
            }
        }

        return $aRecordSet;
    }

    /**
     * Decrypt ID in an Array
     *
     * @param array $aRecordSet ['encrypted']
     * @param array $sColumnId
     * @return array $aRecordSet ['decrypted']
     */
    public function decrypt_id_in_array($aRecordSet, $sColumnId = null) {

        $x = 0;
        foreach ($aRecordSet as $key => $val) {
            if ($sColumnId != null) {
                $aRecordSet[$x][$sColumnId] = $this->decrypt_param($val[$sColumnId]);
            } else {
                $aRecordSet[$x] = $this->decrypt_param($val);
            }
            $x++;
        }

        return $aRecordSet;
    }

    public function remove_bbcode($sValue) {

        $pattern = array('|[[\/\!]*?[^\[\]]*?]|si', '/\r|\n/');
        $sValue = trim(preg_replace($pattern, ' ', $sValue));
        return $sValue;
    }

    /**
     * Remove BB  ID in an Array
     *
     * @param array $aRecordSet ['string|array']
     * @param array $sColumnId | $aColumnId
     * @return array $aRecordSet ['encrypted']
     */
    public function remove_bbcode_in_array($aRecordSet, $sColumnId) {

        $x = 0;


        if (is_array($sColumnId) !== false) {
            // $iArrayCount = count($sColumnId);

            foreach ($aRecordSet as $key => $val) {
                $i = 0;
                foreach ($sColumnId as $k => $v) {
                    $aRecordSet[$x][$v] = $this->remove_bbcode($val[$v]);
                    $i++;
                }
                $x++;
            }
        } else {

            foreach ($aRecordSet as $key => $val) {
                $aRecordSet[$x][$sColumnId] = $this->remove_bbcode($val[$sColumnId]);
                $x++;
            }
        }

        return $aRecordSet;
    }

    /**
     * BBCode to HTML
     * 
     * @param mixed $bbtext
     * @return mixed $bbtext
     */
    function bbcode_to_html($bbtext) {

        $bbtext = @nl2br($bbtext);
        $bbtags = array(
            '[heading1]' => '<h1>', '[/heading1]' => '</h1>',
            '[heading2]' => '<h2>', '[/heading2]' => '</h2>',
            '[heading3]' => '<h3>', '[/heading3]' => '</h3>',
            '[h1]' => '<h1>', '[/h1]' => '</h1>',
            '[h2]' => '<h2>', '[/h2]' => '</h2>',
            '[h3]' => '<h3>', '[/h3]' => '</h3>',
            '[paragraph]' => '<p>', '[/paragraph]' => '</p>',
            '[para]' => '<p>', '[/para]' => '</p>',
            '[p]' => '<p>', '[/p]' => '</p>',
            '[left]' => '<p style="text-align:left;">', '[/left]' => '</p>',
            '[right]' => '<p style="text-align:right;">', '[/right]' => '</p>',
            '[center]' => '<p style="text-align:center;">', '[/center]' => '</p>',
            '[justify]' => '<p style="text-align:justify;">', '[/justify]' => '</p>',
            '[bold]' => '<span style="font-weight:bold;">', '[/bold]' => '</span>',
            '[italic]' => '<span style="font-weight:bold;">', '[/italic]' => '</span>',
            '[underline]' => '<span style="text-decoration:underline;">', '[/underline]' => '</span>',
            '[b]' => '<span style="font-weight:bold;">', '[/b]' => '</span>',
            '[i]' => '<span style="font-weight:bold;">', '[/i]' => '</span>',
            '[u]' => '<span style="text-decoration:underline;">', '[/u]' => '</span>',
            '[break]' => '<br>',
            '[br]' => '<br>',
            '[newline]' => '<br>',
            '[nl]' => '<br>',
            '[unordered_list]' => '<ul>', '[/unordered_list]' => '</ul>',
            '[list]' => '<ul>', '[/list]' => '</ul>',
            '[ul]' => '<ul>', '[/ul]' => '</ul>',
            '[ordered_list]' => '<ol>', '[/ordered_list]' => '</ol>',
            '[ol]' => '<ol>', '[/ol]' => '</ol>',
            '[list_item]' => '<li>', '[/list_item]' => '</li>',
            '[li]' => '<li>', '[/li]' => '</li>',
            '[*]' => '<li>', '[/*]' => '</li>',
            '[code]' => '<code>', '[/code]' => '</code>',
            '[preformatted]' => '<pre>', '[/preformatted]' => '</pre>',
            '[pre]' => '<pre>', '[/pre]' => '</pre>',
        );

        $bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);

        $bbextended = array(
            "/\[url](.*?)\[\/url]/i" => "<a href=\"http://$1\" title=\"$1\">$1</a>",
            "/\[color](.*?)\[\/color]/i" => "<span color=\"$1\" title=\"$1\">$1</span>",
            "/\[sub](.*?)\[\/sub]/i" => "<sub>$1</sub>",
            "/\[sup](.*?)\[\/sup]/i" => "<sup>$1</sup>",
            "/\[color=.*?\]|\.*?\[\/color\]/i" => "<span style=\"color:$1;\" >$2</span>",
            "/\[size=(.*?)\](.*?)\[\/size]/i" => "<span style=\"font-size:$1;\" >$2</span>",
            "/\[font=(.*?)\](.*?)\[\/font]/i" => "<span style=\"font-family:$1;\" >$2</span>",
            "/\[color=(.*?)\](.*?)\[\/color]/i" => "<span style=\"color:$1;\" >$2</span>",
            "/\[size=.*?\]|\.*?\[\/size\]/i" => "<span style=\"font-size:$1;\" >$2</span>",
            "/\[font=.*?\]|\.*?\[\/font\]/i" => "<span style=\"font-family:$1;\" >$2</span>",
            "/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a href=\"$1\" title=\"$1\">$2</a>",
            "/\[email=(.*?)\](.*?)\[\/email\]/i" => "<a href=\"mailto:$1\">$2</a>",
            "/\[mail=(.*?)\](.*?)\[\/mail\]/i" => "<a href=\"mailto:$1\">$2</a>",
            "/\[img\]([^[]*)\[\/img\]/i" => "<img src=\"$1\" alt=\" \" />",
            "/\[image\]([^[]*)\[\/image\]/i" => "<img src=\"$1\" alt=\" \" />",
            "/\[image_left\]([^[]*)\[\/image_left\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_left\" />",
            "/\[image_right\]([^[]*)\[\/image_right\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_right\" />",
        );

        foreach ($bbextended as $match => $replacement) {
            $bbtext = preg_replace($match, $replacement, $bbtext);
        }
        return $bbtext;
    }

    /**
     * Generate 4 digit numbers for Your One Time Password
     *
     * @return string $OTP
     */
    public function generateCaseControlNumber() {
//        $digits = 4;
//        $OTP = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
//        return $OTP;

        $randomChar = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
        $yearAndTime = date("yh-im");
        $caseControlNumber = $_SESSION['userData']['govt_agency_type_id'] . $randomChar . date("d") . "-" . $yearAndTime;
        return $caseControlNumber;
    }

    /**
     * Generate hashid for OTP validation
     *
     * @param type $iLength
     * @return string $hashID
     */
    public function generateHASHID($iLength = 12) {
        $hashID = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz9876543210ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $iLength);
        return $hashID;
    }

    /**
     * Generate Access code for OTP validation
     *
     * @param type $iLength
     * @return string $hashID
     */
    public function generateAcessCode($iLength = 6) {
        $acode = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $iLength);
        return $acode;
    }

    /**
     * Function to get the user IP address
     *
     * @return mixed
     */
    public function getUserIP() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function getUserIDByAccessKey($accessKey) {

        $userID = 0;
        //update last modified
        $sQuery = "UPDATE `icms_user_app_access` SET `user_app_access_modified`=now() WHERE `user_app_access_is_active` = 1 AND `user_app_access_key` like '" . $accessKey . "'";
        $this->Exec($sQuery);
        $sSequel = "SELECT `user_id` FROM `icms_user_app_access` WHERE `user_app_access_is_active` = 1 AND `user_app_access_key` like '" . $accessKey . "'";
        $userID = $this->GetOne($sSequel);

        return $userID;
    }

    public function getUserAccessIsStillActive($userID) {
        $sQuery = "SELECT `user_is_active`,`agency_is_active`,`agency_branch_is_active`,`user_level_is_active` FROM `icms_user` WHERE `user_id` = '" . $userID . "'";
        $data = $this->GetRow($sQuery);
        return $data;
    }

    public function checkDateIfExist($date) {
        $sResponseDate = 'NULL';
        if (!empty($date) == true) {
            $sResponseDate = "'" . date("Y-m-d", strtotime($date)) . "'";
        }
        return $sResponseDate;
    }

    public function checkDateTimeIfExist($date) {
        $sResponseDate = 'NULL';
        if (!empty($date) == true) {
            $sResponseDate = "'" . date("Y-m-d H:i", strtotime($date)) . "'";
        }
        return $sResponseDate;
    }

    public function checkifStringExist($sParam) {
        $sResponseString = 'NULL';
        if (!empty($sParam) == true) {
            $sResponseString = "'" . $sParam . "'";
        }
        return $sResponseString;
    }

    public function checkIntIfExist($param) {
        $sResponseString = 'NULL';
        if (!empty($sParam) == true) {
            $sResponseString = "" . $sParam . "";
        }
        return $sResponseString;
    }

    public function checkUserIsTag($case_id) {
        $sQuery = "
                SELECT 
                    COUNT(`case_tagged_users_id`)
                FROM    
                    `icms_case_tagged_users` 
                WHERE 
                    `user_id` = " . $_SESSION['userData']['user_id'] . " 
                AND `case_id` = " . $case_id . " 
                AND `case_tagged_users_status` = 1
                ";
        $data = $this->GetOne($sQuery);
//        die($data); 
        return $data;
    }

    public function checkServiceLogUrl($aParam) {
        $sQuery = "
                SELECT 
                    COUNT(`case_victim_services_id`)
                FROM    
                    `icms_case_victim_services_agency_tag` 
                WHERE 
                    `case_victim_services_agency_tag_is_active` = 1 AND 
                    `case_victim_services_id` = " . $aParam['case_victim_services_id'] . " 
                AND `agency_branch_id` = " . $aParam['agency_branch_id'] . " 
                ";
        $data = $this->GetOne($sQuery);
//        die($data); 
        return $data;
    }

    function html_entity_encode($data) {
        if (is_array($data)) {
            return array_map(array($this, 'encode'), $data);
        }
        if (is_object($data)) {
            $tmp = clone $data; // avoid modifing original object
            foreach ($data as $k => $var)
                $tmp->{$k} = $this->encode($var);
            return $tmp;
        }
        return htmlentities($data);
    }

    function html_entity_decode($data) {
        if (is_array($data)) {
            return array_map(array($this, 'html_entity_decode'), $data);
        }
        if (is_object($data)) {
            $tmp = clone $data; // avoid modifing original object
            foreach ($data as $k => $var)
                $tmp->{$k} = $this->html_entity_decode($var);
            return $tmp;
        }
        return html_entity_decode($data);
    }

}
