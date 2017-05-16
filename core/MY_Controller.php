<?php defined("BASEPATH") or exit("No direct scripts allowed");
/**
 *  Custom Controller for CodeIgniter V 3.* & PHP Version 5.5.*
 *  Current Functionalities
 *  1. render - Renders a view with a parent template
 *            - Uses 'templates/default' as default
 *            - Has 2 Sub-Classes
 *              - Public_Controller - for public views, loads 'templates/public'
 *              - Secured_Controller  - put your authentication / session Checks
 *                                    on the constructor.
 *                                  - uses 'templates/secured' as template
 *  2.return_json - Return $response as JSON Data
 */

class MY_Controller extends CI_Controller {

	/**
	 * Store data for usage inside views
	 */
	protected $data = [];

	/**
	 * Store data for response_json
	 */
	protected $response = [];

	/**
	 * Default Master Template
	 */
	protected $view_template = 'templates/default';

	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct();

		/**
		 * Custom JavaScripts per page
		 */
		 $this->data['js_includes'] = [];

		/**
		 * Custom JavaScripts Snippets
		 */
		 $this->data['embed_body'] = [];

	}

	/**
	 * Renders View inside default templates
	 * @param  String  $subview
	 * @return HTML
	 */
	public function render($subview = NULL){
		# Catch NULL Subview
		if(is_null($subview)){
			show_error('Subbiew was not set.',500, $heading = 'An Error Was Encountered');
		}
		# Load View
		$this->data['subview'] = $subview;
		$this->load->view($this->view_template,$this->data);
	}

	/**
	 * Returns $response as JSON Data
	 * @return JSON
	 */
	public function return_json(){
		$this->output
	         ->set_content_type('application/json')
	         ->set_output(json_encode($this->response));
	}
}

/**
 * Sub Class for Public Pages
 */
class Public_Controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->view_template = 'templates/public';
	}

}

/**
 * Sub Class for Secured Pages
 */
class Secured_Controller extends MY_Controller{

	public function __construct(){
		parent::__construct();

		# Do some session / authentication validation here

		$this->view_template = 'templates/secured';
	}

}
