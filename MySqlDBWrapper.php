<?php

/**
 * MySqlDBWrapper - MySQL Database Access
 * PHP Version 7.4
 *
 * @category  MySQL Database Access
 * @see         https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 *
 * @author      Alberto Andreo <alberto.andreo@gmail.com>
 * @copyright   2022 - 2030 Alberto Andreo
 * @version     1.0.2
 * @license     http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
class MySqlDBWrapper {

    /**
    * MySQLi instance
    *
    * @var mysqli
    */    
    private $_mysqli = null ;

    /**
    * If the connection to the DB has been established, it is set to true or false otherwise
    *
    * @var bool
    */    
    private $_connected ;

    /**
    * Hostname of the DB server
    *
    * @var string
    */    
    private $_dbHost ;

    /**
    * MySQL DB username
    *
    * @var string
    */    
    private $_dbUser ;

    /**
    * MySQL DB password
    *
    * @var string
    */    
    private $_dbPassword ;

    /**
    * MySQL DB name
    *
    * @var string
    */    
    private $_dbName ;

    /**
    * MySQL DB collation
    *
    * @var string
    */    
    private $_dbCollation ;

    /**
    * MySQL error message number
    *
    * @var int
    */    
    public $mySqlErrNo ;

    /**
    * MySQL error message text
    *
    * @var string
    */    
    public $mySqlError ;

    /**
    * Holds the total number of rows affected by the last query
    *
    * @var string
    */    
    public $AffectedRows ;

   /**
     * @param string $DbHost
     * @param string $DbUser
     * @param string $DbPassword
     * @param string $DbName
     * @param string $DbCollation
     */    
    function __construct($DbHost = 'localhost', $DbUser = null, $DbPassword = null, $DbName = null, $DbCollation = 'utf8mb4') {

        $this->_connected = false ;
		$this->_dbHost = $DbHost ;
        $this->_dbUser = $DbUser ;
        $this->_dbPassword = $DbPassword ;
        $this->_dbName = $DbName ;
        $this->_dbCollation = $DbCollation ;

        // Initialize default values for all object properties
        $this->setMySQLErrNo(0) ;
        $this->setMySQLError('') ;
        $this->setAffectedRows(0) ;

        // DB connection call point
        $this->Connect() ;

	}

    /**
     * Private setter for property mySqlErrNo
     *
     * @param int $MySQLErrNo
     *
     * @return void
     */    
    private function setMySQLErrNo($MySQLErrNo) {
        $this->MySQLErrNo = $MySQLErrNo ;
    }

    /**
     * Private getter for property mySqlErrNo
     *
     * @return int
     */    
    private function getMySQLErrNo() {
		return $this->MySQLErrNo ;
	}

    /**
     * Private setter for property mySqlError
     *
     * @param string $mySqlError
     *
     * @return void
     */    
    private function setMySQLError($mySqlError) {
        $this->mySqlError = $mySqlError ;
    }

    /**
     * Private getter for property mySqlError
     *
     * @return string
     */    
    private function getMySQLError() {
		return $this->mySqlError ;
	}

    /**
     * Private setter for property AffectedRows
     *
     * @param int $AffectedRows
     *
     * @return void
     */    
    private function setAffectedRows($AffectedRows) {

        $this->AffectedRows = $AffectedRows ;

    }

    /**
     * Private getter for property AffectedRows
     *
     * @return int
     */    
    private function getAffectedRows() {
		return $this->AffectedRows ;
	}

    /**
     * Method to connect the MySQL DB
     *
     * @throws Exceptions
     * @return void
     */
    private function Connect() {

        $this->_connected = false ;

        // Try to connect the database. In case of errors throws an exception
        $mysqli = new mysqli($this->_dbHost, $this->_dbUser, $this->_dbPassword, $this->_dbName) ;
        if ($mysqli->connect_errno) {
            $this->setMySQLErrNo($mysqli->connect_errno) ;
            $this->setMySQLError($mysqli->connect_error) ;
            throw new Exception('MySQL Connect Error ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error, $mysqli->connect_errno);
        }

        $this->_connected = true ;

        // Set the internal object to the established connection
        $this->_mysqli = $mysqli ;

        $this->Query("SET NAMES " . $this->_dbCollation) ;

    }

    /**
     * Method to perform queries against the DB
     *
     * @param string $sql
     *
     * @throws Exceptions
     * @return mysqli_result
     */
    public function Query($sql) {

        if (!$this->_connected)
            throw new Exception('Impossible to query the DB without a connection');

        echo "Query: $sql\n" ;

        // Try to execute the given SQL query and in case of errors throws an exception
        if (!$this->_mysqli->real_query($sql)) {
            $this->setMySQLErrNo($this->_mysqli->errno) ;
            $this->setMySQLError($this->_mysqli->error) ;
            throw new Exception('MySQL Query Error ' . $this->_mysqli->errno . ': ' . $this->_mysqli->error, $this->_mysqli->errno);
        }

        // Get query result set
        $result = $this->_mysqli->store_result() ;

        // Set the total number of rows affected by the given query
        $this->setAffectedRows($this->_mysqli->affected_rows) ;

        return($result) ;

    }

    /**
     * Method to get the total number of rows from the given table name
     *
     * @param string $tableName
     *
     * @return int
     * @return Exceptions
     */
    public function CountTableRows($tableName) {
        $this->Query("SELECT * FROM $tableName") ;
        return($this->getAffectedRows()) ;
    }

    /**
     * Method to close the database connection. Returns true in case of success or false on failure
     *
     * @return bool
     */
    public function Disconnect() {

        $this->_connected = false ;

        return($this->_mysqli->close()) ;

    }

}

?>