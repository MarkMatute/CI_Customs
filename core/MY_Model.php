<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  Custom Model for CodeIgniter V 3.* & PHP Version 5.5.*
 *  Current Functionalities
 *  1. all - Getting all records
 *         - Getting paginated Results
 *  2. get - Getting a single record by passing its id
 *         - return FALSE if no data was found
 *  3. save- saving a single record
 *         - can return an object of record saved
 *  4. update-update a single record
 *           - can return an object of record updated
 *  5. delete-delete a single record
 *  6. count_all-counts all records
 *
 *  Future:
 *  1. auto cache and flush cache
 *
 */

class MY_Model extends CI_Model {

	/**
	 * Table's name in the database
	 */
	protected $table = '';

	/**
	 * Used to store results on the query
	 */
	protected $records = [];

	/**
	 * Default number of paginated results per page
	 */
	protected $pagination_per_page = 20;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All records
	 *  'pagination' => [
 	 *	    'base_url' => base_url('/api/get_records')
 	 *      'per_page' => 10,
   *      'page'     => $page
 	 *   ]
	 * @param  Mixed $options
	 * @return Mixed
	 */
	public function all($options = []){

		# Paginated Results
		if(isset($options['pagination'])){

			$this->load->library('pagination');

			# Check Pagination URL
			if(!isset($options['pagination']['base_url'])){
				show_error('Pagination base_url was not set.',500, $heading = 'An Error Was Encountered');
			}

			# Check Page Number
			if(!isset($options['pagination']['page'])){
				show_error('Pagination page was not set.',500, $heading = 'An Error Was Encountered');
			}

			# Set Pagination Options
			if(!isset($options['pagination']['per_page'])){
				$options['pagination']['per_page'] = $this->pagination_per_page;
			}

			# Set Pagination Total Rows
			$options['pagination']['total_rows'] = $this->count_all();

			# Use Page numbers
			$options['pagination']['use_page_numbers'] = TRUE;

			# Run Pagination
			$this->pagination->initialize($options['pagination']);

			# Limit & Offset
			$limit  = $options['pagination']['per_page'];
			$offset = $options['pagination']['page'] > 1 ? $limit *( $options['pagination']['page'] - 1) : 0;

			# Get records
			$this->records['results'] = $this->db->limit($limit,$offset)->get($this->table)->result();

			# Create Links
			$this->records['links'] = $this->pagination->create_links();

			return $this->records;
		}

		# Not Paginated
		$this->records = $this->db->get($this->table)->result();

		# Return Records
		return count($this->records) > 0 ? $this->records : FALSE;
	}


	/**
	 * Get a single record
	 * @param  Integer $id
	 * @return Mixed
	 */
	public function get($id = NULL){
		if(is_null($id) || !is_numeric($id)){
			show_error('Id has invalid value.',500, $heading = 'An Error Was Encountered');
		}
		$record = $this->db->where('id',$id)->get($this->table)->row();
		return count($record) > 0 ? $record : FALSE;
	}

	/**
	 * Save a record
	 * @param  Array $data
	 * @param  Array $options
	 * @return Mixed
	 */
	public function save($data = [],$options = []){

		# Ensure data is array
		$data = is_object($data) ? (array)$data : $data;

		# Insert Record
		$this->db->insert($this->table, $data);

		# Return Object
		if(isset($options['return']) && $options['return']=='object'){
			$id = $this->db->insert_id();
			return $this->get($id);
		}

		return TRUE;
	}

	/**
	 * Update a record
	 * @param  Integer  $id
	 * @param  Mixed  $data
	 * @param  Mixed  $options
	 * @return Mixed
	 */
	public function update($id=NULL,$data = [],$options = []){

		# Check $id
		if(is_null($id) || !is_numeric($id)){
			show_error('Invalid parameter id.',500, $heading = 'An Error Was Encountered');
		}

		# Ensure data is array
		$data = is_object($data) ? (array)$data : $data;

		# Update Record
		$this->db->where('id',$id);
		$this->db->update($this->table, $data);

		# Return Object
		if(isset($options['return']) && $options['return']=='object'){
			return $this->get($id);
		}

		return TRUE;
	}

	/**
	 * Delete a record
	 * @param  Integer  $id
	 * @return Boolean
	 */
	public function delete($id=NULL){
		# Check $id
		if(is_null($id)||!is_numeric($id)){
			show_error('Invalid parameter id.',500, $heading = 'An Error Was Encountered');
		}
		$this->db->where('id',$id);
		$this->db->delete($this->table);
		return TRUE;
	}

	/**
	 * Count all records
	 * @param  Array  $options
	 * @return Integer
	 */
	public function count_all($options = []){
		$count = $this->db->count_all($this->table);
		return $count;
	}
}

/* End of file MY_Model.php */
/* Location: ./application/models/MY_Model.php */
