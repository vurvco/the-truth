<?php
class Class_Base_Abstract_Guest_Book_LdvJarim {
    // Next comes the variable list as defined above
    // Note the key word 'var' and then a comma-separated list
    public static $LORTISSSS='lortis';
    public $status;

    // Next come all our methods with their argument lists

	
public function mysql_escape_mimic($inp) {
   /* if(is_array($inp))
        return array_map(__METHOD__, $inp);
	*/
    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
} 

public function mysql_escape_simple_quote_with_double_quote_Jarim($inp) {
   /* if(is_array($inp))
        return array_map(__METHOD__, $inp);
	*/
    if(!empty($inp) && is_string($inp)) {
        return str_replace(array("'"),array('"'), $inp);
    }
    
    return $inp;
} 

public function executeSQL($sql)
{
//CALL $result = $this->executeSQL($sql);

    $this->status=true;

    if (!$result = mysql_query($sql)) 
    {
            echo "Error query showAllPostsHTML<br>";
            $result = ($result) ? 'true' : 'false';
            echo $sql.'<br>  RESULT = '.$result.'<br><br>';
            echo $result;
            $status=false;
            echo "<br>FUNCTION = ". __FUNCTION__;
            echo "<br>CLASS+METHOD = ".__METHOD__;
            $this->status=false;
            exit;
    }

    return $result;

}

	

public function listMyProperties() 
{
    echo "My properties are: ";
    print_r( get_object_vars( $this ) );

}

public function listMyConstants()
{
    $reflect = new ReflectionClass(get_class($this));
	print_r($reflect->getConstants());
}

public function listMyMethods() 
{
    echo "My methods are: ";
    print_r(get_class_methods( $this ) );
}

public function sanityCheckMysqlScapeByReference(&$string, $type, $length)
{
	
    /*TESTING
            echo '
            real type = '.gettype($string);
            echo '
            Real-length = '.strlen($string);
            echo '
            Real string= "'.$string;

    END TESTING*/

    if (!(isset( $string )) || $string==""){return FALSE;}      
      
    // assign the type
    $type = 'is_'.$type;

    if(!$type($string))
    {
        return FALSE;
        //echo 'type';

    }
      // now we see if there is anything in the string
    if(empty($string))
    {
        return FALSE;
        //echo 'empty';
    }
    // then we check how long the string is
    if(strlen($string) > $length)
    {
        return FALSE;
        //echo 'len';
    }

    // if all is well, we return TRUE
    //$string=mysql_real_escape_string($string);
    //$string=12;
    return TRUE;
    
}







}//END Class_Base_Abstract_Guest_Book_LdvJarim