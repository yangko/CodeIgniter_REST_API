<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* User Model
*/

class User_Model extends CI_Model 
{
     /**
     * Holds the name of the table in use by this model.
     *
     * @name string applications
     */
    const TABLE_NAME = 'users';

    /**
     * Holds the name of the tables' primary index used in this model.
     *
     * @name string id
     */
    const PRI_INDEX = 'user_id';

    /**
     * Retrieves record(s) from the database
     *
     * @param array $cols - An array of columns to select, if an empty array is provided all columns are selected
     * @param mixed $where Optional. Retrieves only the records matching given criteria, or all records if not given.
     *                      If associative array is given, it should fit field_name=>value pattern.
     *                      If string, value will be used to match against PRI_INDEX
     * @return mixed Single record if ID is given, or array of results
     */

    public function get($cols = [], $where = NULL)
    {
        if ( ! empty($cols))
        {
            foreach($cols as $col)
            {
                $this->db->select($col);
            }
        }
        else
        {
            $this->db->select('*');
        }

        $this->db->from(static::TABLE_NAME);

        if ($where !== NULL)
        {
            if (is_array($where))
            {
                foreach ($where as $field=>$value)
                {
                    $this->db->where($field, $value);
                }
            }
            else
            {
                $this->db->where(static::PRI_INDEX, $where);
            }
        }

        $result = $this->db->get()->result_array();

        if ($result)
        {
            return $result;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Inserts a new item into the database
     *
     * @param array $data - associative array, should fit field_name=>value pattern.
     *
     * @return int - new item id
     */
    public function create(array $data)
    {
        if (empty($data))
        {
            throw new Exception('Please provide an associative array of user data to insert.  Keys should match column names.');
        }

        if ($this->db->insert(static::TABLE_NAME, $data))
        {
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

     /**
     * Updates selected record in the database
     *
     * @param array $data Associative array field_name=>value to be updated
     * @param array $where Optional. Associative array field_name=>value, for where condition. If specified, $id is not used
     * @return int Number of affected rows by the update query
     */
    public function update(array $data, $where = array())
    {
        if (empty($where))
        {
            throw new Exception('Please provide a where clause for this update statement');
        }

        if ( ! is_array($where)) {
            $where = array(static::PRI_INDEX => $where);
        }

        $this->db->update(static::TABLE_NAME, $data, $where);

        return $this->db->affected_rows();
    }

    /**
     * Deletes specified record from the database
     *
     * @param array $where Optional. Associative array field_name=>value, for where condition. If specified, $id is not used
     * @return int Number of rows affected by the delete query
     */
    public function delete($where = array())
    {
        if (empty($where))
        {
            throw new Exception('Please provide a where clause for this delete statement');
        }

        if ( ! is_array($where))
        {
            $where = array(static::PRI_INDEX => $where);
        }

        $this->db->delete(static::TABLE_NAME, $where);

        return $this->db->affected_rows();
    }

    /**
     * Checks to see if a model with the given id exists in the system
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function check_exists(int $id)
    {
        if ( ! $id)
        {
            throw new Exception('Please supply an id');
        }

        if ($this->get([static::PRI_INDEX], $id) !== FALSE)
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Checks to see if a model with the given id exists in the system
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function user_auth($username, $password)
    {
        $where = [
            'username' => $username,
            'password' => $password
        ];

        $result = $this->get([], $where);

        if ($result)
        {
            return $result[0];
        }
        else
        {
            return FALSE;
        }
    }

}