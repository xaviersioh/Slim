<?php
/** Control script to test the Person and PersonView classes
*/
	ini_set('display_errors', 'on');
	ini_set('html_errors', 'on');
	require_once 'class.Person.php';
	require_once 'class.PersonView.php';

	$arr_output = array();
	$obj_person = new Person();
	$obj_person->set_value('name', 'Bill');
	$obj_person->set_value('date_of_birth', '11 August 1948');
	$arr_output[1] = $obj_person->say_hello();

	// this should trigger an error
	$obj_person2 = new Person();

	$obj_person2->set_value('name', 'Fred');
	$obj_person2->set_value('date_of_birth', '21 October 2011');
//	$obj_person2->set_value('date_of_birth', 'blue');
//	$obj_person2->set_value('date_of_birth', '21 October 2011');
	$arr_output[2] = $obj_person2->say_hello();

	$obj_view = new PersonView();
	$obj_view->set_page_title('Person Class Demonstration');
	$obj_view->set_page_content($arr_output);
	$output_html = $obj_view->get_output_html();
	echo $output_html;
?>
