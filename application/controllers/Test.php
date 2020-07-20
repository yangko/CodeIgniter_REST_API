<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Test controller
*
* @package     Test
* @subpackage  Controllers
* @author      Wei Yang <yangko@hotmail.com>
*/

class Test extends CI_Controller 
{
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
		$this->load->library('twig');

        $this->load->model('movie_model'); 
    }
    
    public function index()
	{
        $movies = $this->movie_model->get_movies();
        $genres = $this->db->get("genres")->result();

        $data = [
            'pageHeading' => 'REST API Testing',
            'errors' => $this->session->flashdata(),
            'movies' => $movies,
            'genres' => $genres,
		];

		$this->twig->display('test/index.html', $data);
    }

    /**
	 * IG-2 User Photo Post and List
	 */
	public function show_postman()
	{
        $data = [
            'pageHeading' => 'REST API Testing',
            'errors' => $this->session->flashdata(),
            'photo_url' => $this->config->item('base_url') . 'store/files/'
		];

		$this->twig->display('test/show.html', $data);
	}
}