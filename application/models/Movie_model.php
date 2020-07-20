<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Movie Model
*/

class Movie_Model extends CI_Model 
{
     /**
     * Holds the name of the table in use by this model.
     *
     * @name string applications
     */
    const TABLE_NAME = 'movies';

    /**
     * Holds the name of the tables' primary index used in this model.
     *
     * @name string id
     */
    const PRI_INDEX = 'id';

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
     * Retrieve all movies
     *
     * @param integer $id // the movie_id
     *
     * @return array
     */
    public function get_movies($id = NULL)
    {
        $where = empty($id) ? " 1=1 " : " m.id=" . $id;
        
        $sql = "SELECT m.*, g.name AS 'genre_type'
            FROM movies m
            INNER JOIN genres g ON m.genre_type_id=g.type_id 
            WHERE $where
            ORDER BY m.title ASC 
            ";

        // Retrieve Actor information as well 
        if ( !empty($id)) {
            $data = $this->db->query($sql)->row_array();

            $data['actors'] = $this->get_movie_actors($id);
        } else {
            $data = $this->db->query($sql)->result();

            foreach($data as $i => $movie_obj) {
                $data[$i]->actors = $this->get_movie_actors($data[$i]->id);
            }
        }
        
        return $data;
    }

    /**
     * Retrieve all actors for a movie
     *
     * @param integer $movie_id // the movie_id
     *
     * @return array
     */
    public function get_movie_actors($movie_id)
    {
        if ( !$movie_id)
        {
            throw new Exception('Please supply a movie id');
        }

        $sql = "SELECT ma.actor_id, a.name AS actor_name
            FROM movies_actors ma
            LEFT JOIN actors a ON ma.id=a.id
            WHERE ma.movie_id=$movie_id
            ";

        return $this->db->query($sql)->result_array();
    }
}