MySqlDBWrapper -- Powerful and easy to use MySQLi wrapper for PHP
<hr>

### Table of Contents

**[How to instantiate the class](#how-to-instantiate-the-class)**  
**[Insert Query](#insert-query)**  
**[Update Query](#update-query)**  
**[Delete Query](#delete-query)**  
**[Select Query](#select-query)**  
**[Closing the connection](#closing-the-connection)**  
**[Count table rows](#count-table-rows)**  
**[Get affected rows](#get-affected-rows)**  

<hr>
### Support Me

If you like this class and use it in your PHP applications, I invite you to perform even a small donation. It would be greatly appreciated for all the time I have spent testing, documenting and sharing this code.

[Donate with PayPal](https://www.paypal.com/donate/?hosted_button_id=HRJK39W2JKQZQ)

### How to use this class
In order to use this class within your code, you must first include it in your PHP scripts like in the example below:

```php
require_once ('MySqlDBWrapper.php');
```
<hr>
### How to instantiate the class
Simple initialization with *utf8mb4* charset set by default:
```php
$MyDB = new MySqlDBWrapper($DbHost, $DbUser, $DbPassword, $DbName) ;
```

Advanced initialization:
```php
$MyDB = new MySqlDBWrapper($DbHost, $DbUser, $DbPassword, $DbName, $DbCollation) ;
```
*DbCollation* parameter is optional. On success returns a mysqli object.

In the event of MySQL errors when connecting to the database, an exception is thrown.

<hr>
### Insert Query
In order to insert new rows in a given table, call the *Query* method as shown in the example below, passing the SQL query as an input argument:
```php
$MyDB->Query("Insert Into MyTable Set MyColumn1='MyValue1', MyColumn2='MyValue2', MyColumn3='MyValue3'") ;
```

In the event of MySQL errors executing the given query, an exception is thrown.

<hr>
### Update Query
In order to update rows in a given table, call the *Query* method as shown in the example below, passing the SQL query as an input argument:
```php
$MyDB->Query("Update MyTable Set MyColumn1='NewValue' Where MyColumn2='WhereValue'") ;
```

In the event of MySQL errors executing the given query, an exception is thrown.

### Delete Query
In order to delete rows from a given table, call the *Query* method as shown in the example below, passing the SQL query as an input argument:
```php
$MyDB->Query("Delete From MyTable Where MyColumn1='WhereValue'") ;
```

In the event of MySQL errors executing the given query, an exception is thrown.

### Select Query
The *Query* method returns a *mysqli_result* object that may optionally be used to retrieve the various fields returned in the result set of a SELECT query. The example below allows you to understand how to execute a SELECT query against the DB and to retrieve the values of the various columns using an associative array:
```php
$result = $MyDB->Query("Select col1, col2, col3 FROM MyTable Where col4!=0") ;
while ($row = $result->fetch_assoc()) {
    $col1 = $row['col1'] ;
    $col2 = $row['col2'] ;
    $col3 = $row['col3'] ;
    
    // do something
    
}
$result->close();
```

In the event of MySQL errors executing the given query, an exception is thrown.

<hr>
### Closing the connection
In order to close the database connection handle, it is sufficient to call the *Disconnect* method. In case of success return the value *true* otherwise *false*.
```php
$MyDB->Disconnect() ;
```
<hr>
### Count table rows
The simplest way to count how many rows are contained in a given table or view is to call the *CountTableRows* method. In the example below, the variable *$rowsCount* will contain the total number of rows found in a specific table or view.
```php
$rowsCount = $MyDB->CountTableRows('tableName') ;
```
In the event of MySQL errors executing the given query, an exception is thrown.

<hr>
### Get affected rows
Returns the total number of rows that have been processed by the last query.
```php
$affectedRows = $MyDB->AffectedRows ;
```
