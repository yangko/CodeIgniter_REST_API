<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
     
class Movie extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();

       $this->load->model('movie_model'); 
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        if (!empty($id) && !is_numeric($id)) {
            throw new Exception('Please supply with a numeric ID.');
        }
        
        $data = $this->movie_model->get_movies($id);
        //var_dump($data);
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();
        $this->db->insert('movies',$input);
     
        $this->response(['movie created successfully.'], REST_Controller::HTTP_OK);
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('movies', $input, array('id'=>$id));
     
        $this->response(['movie updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('movies', array('id'=>$id));
       
        $this->response(['movie deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}