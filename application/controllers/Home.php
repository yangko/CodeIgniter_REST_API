<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Home controller
*
* @package     Home
* @subpackage  Controllers
* @author      Wei Yang <yangko@hotmail.com>
*/

class Home extends CI_Controller 
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
	}

	public function index()
	{
		$data = [
			'pageHeading' => 'Marketing and Digital Strategy, Cabinet Office',
			'errors' => $this->session->flashdata()
		];

		$this->twig->display('home/index.html', $data);
	}
}