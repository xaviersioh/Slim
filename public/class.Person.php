<?php
/**
 * class to demonstrate overloaded getter & setter methods
 * Uses the magic methods __get & __set to access attributes
 *
 * Accepts two attributes: name & date_of_birth
 *
 * Also uses call_user_func(): calls a user defined function with the first
 * parameter as the function name
 *
 * Class could be updated to accept any attribute name
 */

	class Person
	{
		private $c_arr_attributes;

		public function __construct()
		{
			$this->c_arr_attributes = array('name' => null, 'date_of_birth' => null);
		}

		public function __destruct() {}

/**
 * Implement the magic method _get()
 *
 * First checks to see if the attribute exists in the storage array.  Then
 * checks to see if the get() method for that attribute exists
 *
 * @param $p_attribute_id: accepts the name of the attribute
 */
		public function __get($p_attribute_id)
		{
			$m_attribute_value = null;
			try
			{
				if (!array_key_exists($p_attribute_id, $this->c_arr_attributes))
				{
					throw new Exception('Unknown attribute');
				}
				else
				{
					if (method_exists($this, 'get_' . $p_attribute_id))
					{
						$m_attribute_value = call_user_func(array($this, 'get_' . $p_attribute_id));
					}
					else
					{
						$m_attribute_value = $this->c_arr_attributes[$p_attribute_id];
					}
				}
			}
			catch (Exception $err)
			{
				trigger_error('<p>Caught exception: ' . $err->getMessage() . '</p>');
			}
			return $m_attribute_value;
		}

/**
 * Implement the magic method __set()
 *
 * Accepts the name and value of a class attribute.  Checks to see that the
 * attribute name exists in the storage array.  Then checks to see if the
 * method exists
 *
 * @param $p_attribute_id: accepts the name of the attribute
 * @param $p_attribute_value: accepts the value to be asigned
 */
		public function __set($p_attribute_id, $p_attribute_value)
		{
			try
			{
				if (!array_key_exists($p_attribute_id, $this->c_arr_attributes))
				{
					throw new Exception('Unknown attribute');
				}
				else
				{
					if (method_exists($this, 'set_' . $p_attribute_id))
					{
						call_user_func(array($this, 'set_' . $p_attribute_id), $p_attribute_value);
					}
					else
					{
						$this->c_arr_attributes[$p_attribute_id] = $p_attribute_value;
					}
				}
			}
			catch (Exception $m_err)
			{
				trigger_error('<p>Caught exception: ',  $m_err->getMessage(), '</p>');
			}
		}

/**
 *	Assign the date of birth to attibute variable
 *
 *	Accepts the date of birth and validates it.  If date is OK
 *	assigns the value to the class attribute.
 *	NB doesn't use the magic __set() method as this method exists
 *
 * Could be updated to return a soothing message to the user in
 * addition to the trigger_error() which write an entry in the error log file
 *
 *	@param $p_dob : accept a date of birth
 */
		private function set_date_of_birth($p_dob)
		{
			try
			{
				if (!strtotime($p_dob))
				{
					throw new Exception('<p>Invalid date entered</p>');
					$this->date_of_birth = '';
				}
				else
				{
					$this->c_arr_attributes['date_of_birth'] = $p_dob;
				}
			}
			catch (Exception $m_err)
			{
				trigger_error('<p>Caught exception: ' . $m_err->getMessage() . '</p>');
			}
		}

/**
 * Assign a value to a class attribute
 *
 * Function to set a value for the given attribute name. Attribute
 * is accessed with the magic method __set()
 *
 * @param $p_attribute_name : accepts the name of the attribute
 * @param $p_attribute_value : accepts the value of the attribute
 */
		public function set_value($p_attribute_name, $p_attribute_value)
		{
			$this->$p_attribute_name = $p_attribute_value;
		}

/**
 * Create the output from the class and return it
 *
 * Attribute values are accessed with the magic method __get()
 */
		public function say_hello()
		{
			$m_message = '';
			if ($this->date_of_birth != '')
			{
				$m_message  = '<p>Hello ' . $this->name;
				$m_message .= '. You were born on ' . $this->date_of_birth . '</p>';
			}
			return $m_message;
		}
	}
?>
