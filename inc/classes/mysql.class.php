<?php

/**
 * @author Janek Ostendorf (ozzy) <ozzy@skyirc.net>
 * @copyright Copyright (c) Janek Ostendorf (ozzy)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */

// Restrict access
if(!defined("IN_POSTPONE")) {
    die("Do not open files seperately!");
}

class mysql {
    
    /** 
     * Server Host
     * @var string
     */
    var $host;
    
    /**
     * Username
     * @var string
     */
    var $user;
    
    /**
     * Password
     * @var string
     */
    var $password;
    
    /**
     * Database name
     * @var string 
     */
    var $database;
    
    /**
     * Status of connection
     * @var bool 
     */
    var $status = 0;
    
    /**
     * MySQL Connection ID
     * @var mixed 
     */
    var $conID;
    
    /**
     * MySQL Result
     * @var resource 
     */
    var $result;
    
    /**
     * MySQL Error number
     * @var int 
     */
    var $errornum;
    
    /**
     * MySQL error message
     * @var string 
     */
    var $errormessage;
    
    /**
     * Number of executed queries
     * @var int 
     */
    var $queries = 0;    
    
    /**
     * Length of all queries
     * @var int 
     */
    var $query_time = 0;

    
    /**
     * Connects to the MySQL server
     * @param string $host MySQL Server
     * @param string $user MySQL Benutzer
     * @param string $password MySQL Password
     * @return bool Success
     */
    function connect($host, $user, $password) {
        
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        
        if($this->status == 0) {
            
            if(!$this->conID = mysql_connect($this->host, $this->user, $this->password, true)) {
                $this->status = 0;
                $this->errormessage = mysql_error();
                $this->errornum = mysql_errno();
                return 0;
            }
            else {
                $this->status = 1;
                return 1;
            }
            
        }
        
    }
    
    /**
     * Chooses a database
     * @param string $database Name of the database
     * @return bool Success
     */
    function selectDb($database) {
        
        if($this->status == 0) {
            return 0;
        }
        else {
            $this->database = $database;
            if(!mysql_select_db($this->database, $this->conID)) {
                $this->errormessage = mysql_error();
                $this->errornum = mysql_errno();
                return 0;
            }
            return 1;
        }
        
    }
    
    /**
     * Executes the query
     * @param string $query Query
     * @return resource MySQL Result
     */
    function query($query) {
        
        if($this->status == 0) {
            return 0;
        }
        else {
            
            $time_start = microtime(true);
            $this->result = mysql_query($query, $this->conID);
            $this->query_time += microtime(true) - $time_start;
            
            $this->queries++;
            
            if(!$this->result) {
                $this->errormessage = mysql_error();
                $this->errornum = mysql_errno();
                return 0;
            }
            else {
                return $this->result;
            }
        }
        
    }
    
    /**
     * Sets the charset of the MySQL connection
     * @param string $charset Charset
     * @return bool Success
     */
    function setCharset($charset) {
        
        if($this->status == 0) {
            return 0;
        }
        else {
            if(!mysql_set_charset($charset, $this->conID)) {
                return 0;
            }
            else {
                return 1;
            }
        }
        
    }
    
    /**
     * Returns the last error message
     * @return string|bool "Error number : Error message" or false 
     */
    function getLastError() {
        
        if(!empty($this->errormessage) && !empty($this->errornum)) {
            return ($this->errornum . " : " . $this->errormessage);
        }
        else {
            return 0;
        }
        
    }
    
    /**
     * Returns the number of executed queries
     * @return int number of queries
     */
    function getQueries() {
        
        return $this->queries;
        
    }
    
    /**
     * Return the sum of all executed queries (time)
     * @return int Length of all queries (time)
     */
    function getQueryTime() {
        
        return $this->query_time;
        
    }
    
    /**
     * Closes the connection to the Server
     * @return bool Success
     */
    function disconnect() {
        
        if($this->status == 1) {
            if(!mysql_close($this->conID)) {
                return 0;
            }
            else {
                $this->status = 0;
                return 1;
            }
        }
        else {
            return 0;
        }
    }
    
    /**
     * Escapes $string
     * @param string $string
     */
    function escape($string) {
        return mysql_real_escape_string($string);
    }
    
    /**
     * Returns the number of lines of the result
     * @param rescource $result Result. Leave empty to use the last executed query.
     * @return int
     */
    function num_rows($result = null) {
        
        if($result == null) {
            $result = $this->result;
        }
        
        return mysql_num_rows($result);
        
    }
    
}

?>
