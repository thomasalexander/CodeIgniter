<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

/**
 * MSSQL Result Class
 *
 * This class extends the parent result class: CI_DB_result
 *
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 * @since	1.3
 */
class CI_DB_native_mssql_result extends CI_DB_native_result {

	/**
	 * Fetch Field Names
	 *
	 * Generates an array of column names
	 *
	 * @return	array
	 */
	public function list_fields()
	{
		$field_names = array();
		while ($field = mssql_fetch_field($this->result_id))
		{
			$field_names[] = $field->name;
		}

		return $field_names;
	}

	// --------------------------------------------------------------------

	/**
	 * Field data
	 *
	 * Generates an array of objects containing field meta-data
	 *
	 * @return	array
	 */
	public function field_data()
	{
		$retval = array();
		while ($field = mssql_fetch_field($this->result_id))
		{
			$F		= new stdClass();
			$F->name	= $field->name;
			$F->type	= $field->type;
			$F->max_length	= $field->max_length;
			$F->primary_key = 0;
			$F->default	= '';

			$retval[] = $F;
		}

		return $retval;
	}

	// --------------------------------------------------------------------

	/**
	 * Data Seek
	 *
	 * Moves the internal pointer to the desired offset. We call
	 * this internally before fetching results to make sure the
	 * result set starts at zero
	 *
	 * @return	bool
	 */
	protected function _data_seek($n = 0)
	{
		return mssql_data_seek($this->result_id, $n);
	}

	// --------------------------------------------------------------------

	/**
	 * Result - object
	 *
	 * Returns the result set as an object
	 *
	 * @param	string
	 * @return	object
	 */
	protected function _fetch_object($class_name = 'stdClass')
	{
		$row = @mssql_fetch_object($this->result_id);

		if ($class_name === 'stdClass' OR ! $row)
		{
			return $row;
		}

		$class_name = new $class_name();
		foreach ($row as $key => $value)
		{
			$class_name->$key = $value;
		}

		return $class_name;
	}

}

/* End of file mssql_result.php */
/* Location: ./system/database/drivers/native/mssql_result.php */