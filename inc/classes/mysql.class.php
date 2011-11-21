<?php

/**
 * @author Janek Ostendorf (ozzy) <ozzy@skyirc.net>
 * @copyright Copyright (c) Janek Ostendorf (ozzy)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */

// Restrict access
if(!IN_POSTPONE) {
    die("Do not open files seperately!");
}

class mysql {
    
    /** 
     * Server Host
     * @var string
     */
    var $host;
    
    /**
     * Benutzername
     * @var string
     */
    var $user;
    
    /**
     * Passwort
     * @var string
     */
    var $password;
    
    /**
     * Datenbankname
     * @var string 
     */
    var $database;
    
    /**
     * Verbindungsstatus
     * @var bool 
     */
    var $status = 0;
    
    /**
     * MySQL Verbindungs ID
     * @var mixed 
     */
    var $conID;
    
    /**
     * MySQL Ergebnis
     * @var resource 
     */
    var $result;
    
    /**
     * MySQL Fehlernummer
     * @var int 
     */
    var $errornum;
    
    /**
     * MySQL Fehlermeldung
     * @var string 
     */
    var $errormessage;
    
    /**
     * Anzahl der ausgefuehrten Queries
     * @var int 
     */
    var $queries = 0;    
    
    /**
     * Dauer der Queries
     * @var int 
     */
    var $query_time = 0;

    
    /**
     * Verbindet zum MySQL Server
     * @param string $host MySQL Server
     * @param string $user MySQL Benutzer
     * @param string $password MySQL Passwort
     * @return bool
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
     * Waehlt eine Datenbank aus
     * @param string $database Datenbankname
     * @return bool Erfolg
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
     * Fuehrt die Abfrage aus
     * @param string $query Query
     * @return resource MySQL Ergebnis
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
     * Setzt den Zeichensatz der MySQL Verbindung
     * @param string $charset Zeichensatz
     * @return bool Erfolg
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
     * Gibt die letzte Fehlermeldung aus
     * @return string|bool "Fehlernummer : Fehlermeldung" oder false 
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
     * Gibt die Anzahl der ausgefuehrten Queries aus
     * @return int Anzahl der Queries
     */
    function getQueries() {
        
        return $this->queries;
        
    }
    
    /**
     * Gibt die Summe der Dauer aller Queries aus
     * @return int Dauer der Queries in Sekunden
     */
    function getQueryTime() {
        
        return $this->query_time;
        
    }
    
    /**
     * Schliesst die Verbindung zum Server
     * @return bool Erfolg
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
    
}

?>