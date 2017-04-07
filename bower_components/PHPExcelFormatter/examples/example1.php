<?php
/**
 * PHPExcelFormatter example 1
 *
 * @author     Rene Korss <rene.korss@gmail.com>
 */

require_once('../../bower_components/PHPExcel/Classes/PHPExcel.php');
require_once('../PHPExcelFormatter.php');

try
{
    // Load file
    $formatter = new PHPExcelFormatter('example1.xls');

    // Output columns array
    $formatterColumns = array(
        'username' => 'username',
        'phone'    => 'phone_no',
        'email'    => 'email_address'
    );

    // Set our columns
    $formatter->setFormatterColumns($formatterColumns);

    // Output as array
    $output = $formatter->output('a');

    // Print array
    echo '<pre>'.print_r($output, true).'</pre>';

    // Set MySQL table
    $formatter->setMySQLTableName('users');

    // Output as mysql query
    $output = $formatter->output('m');

    // Print mysql query
    echo '<pre>'.print_r($output, true).'</pre>';

}
catch(PHPExcelFormatterException $e)
{
    echo 'Error: '.$e->getMessage();
}

?>
