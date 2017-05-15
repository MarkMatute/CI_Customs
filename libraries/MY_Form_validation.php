<?php defined("BASEPATH") or exit("No direct scripts allowed.");
/**
 *  Custom Form Validation for CodeIgniter V 3.* & PHP Version 5.5.*
 *  Current Functionalities
 *  1. is_unique          - updated to ignore a certain id
 *  2. is_password_strong - checks password if contains Upper, Lower and Special
 *     character
 *  3.
 */

# Custom Form Validation
# Extension of CI's Form Validation Model
class MY_Form_validation extends CI_Form_validation{

    # Constructor
    public function __construct() {
        parent::__construct();
    }

    /**
     * Checks value if already exists but ignores given id
     * @param  String  $str
     * @param  Mixed  $params
     * @return boolean
     */
    public function is_unique($str, $params)
    {
        $data = explode('.', $params);
        $table = $data[0];
        $field = $data[1];
        $this->CI->db->where($field,$str);
        if(isset($data[2])){
            $this->CI->db->where('person_id !=',$data[2]);
        }
        $rs = $this->CI->db->get("users")->row();
        return count($rs)==0?TRUE:FALSE;
    }

    /**
     * Checks Password if strong enough
     * Checks for a Upper, Lower and spacial character in the String
     * @param  String   $password
     * @return boolean
     */
    public function is_password_strong($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        if(!$uppercase || !$lowercase || !$number) {
          $this->CI->form_validation->set_message('is_password_strong', 'Password must contain Upper,Lower letters and a number.');
          return FALSE;
        }
        return TRUE;
    }

}
