# CodeIgniter Custom Classes and Libraries

Collection of custom core classes extensions for practical use and to solve common problems/issues using CodeIgniter Framework.

## Getting Started

1. Copy contents of `core` folder inside your CodeIgniter Project application\core 
2. Copy contetts of `libraries` folder inside your CodeIgniter Project application\libraries

### Prerequisites

You need CodeIgniter 3.* and PHP with atleast 5.5.* version.

### Usage

After copying the files you can now use the following custom classes.
1. MY_Model
   Create your models. Set $this->table to your models database name.
   ```
   class User_m extends MY_Model {
       public function __construct(){
           parent::__construct();
           $this->table = 'users';
       } 
   }
   ```
   This simple User_m Model has now functionalities of basic CRUD operations.
   
   Functions:
   ```
   Get all records.
   $this->User_m->all();
   
   Get all records with pagination.
   $this->User_m->all('pagination' => [
      'base_url' => base_url('/api/get_records')
      'per_page' => 10,
      'page'     => $page
   ]);```
   
   Get a single record by id.
   $this->User_m->get(1);
   
   Saving a record.
   $this->User_m->save([
      'name' => 'Mark',
      'email'=> 'markernest.matute@email.com'
   ]);
   
   Saving a record and return it as object.
   $this->User_m->save([
      'name' => 'Mark',
      'email'=> 'markernest.matute@email.com'
   ],[
      'return' => 'object'
   ]);
   
   Updating a record. Pass the id.
   $this->User_m->update( 1 , [
      'name' => 'Mark',
      'email'=> 'markernest.matute@email.com'
   ]);
   
   Updating a record and return it as object. Pass the id.
   $this->User_m->update( 1 , [
      'name' => 'Mark',
      'email'=> 'markernest.matute@email.com'
   ],[
      'return' => 'object'
   ]);
          
   Deleting a record. Pass id.
   $this->User_m->delete( 1 );
    
   Count all records. 
   $this->User_m->count_all();
    
2. MY_Controller
   ```
   Create your controller
   class Pages extends Public_Controller {
       public function __construct(){
           parent::__construct();
       }
   }
   ```
   Functions :
   * Rendering Views
     ```
     $this->render('pages/login');
     ```
     This function inserts `pages/login` to a master template as a subview.
     Template differ's according to sub-class used.
     * Public_Controller loads `templates\public` master template.
     * Secured_Controller loads `templates\secured` master template.
    * Returning JSON Response
     ```
     $this->response = [
        'status' => FALSE,
        'errors' => 'Errors here'
     ];
     $this->return_json();
     ```
     * Die Dump
     ```
     $this->die_dump($this->response);
     ```
     Pretty dump variables.
     
3. MY_Form_validation
   Extends CodeIgniter's Form_validation class and added some functionalities.
   *is_unique
    Reworked is_unique function to ignore given id.
    ```
    $this->form_validation->set_rules([
        'field' => 'email',
        'name'  => 'Email',
        'rules' => 'is_unique[users.email.1]'
    ]);
    ```
    *is_password_strong
    Checks password for Uppercase, Lowercase and Special Characters.
    ```
     $this->form_validation->set_rules([
        'field' => 'password',
        'name'  => 'Password',
        'rules' => 'is_password_strong'
    ]);
    ```

```     __       __    __       __           __                __              
|  \     /  \  |  \     /  \         |  \              |  \             
| $$\   /  $$  | $$\   /  $$ ______ _| $$_   __    __ _| $$_    ______  
| $$$\ /  $$$  | $$$\ /  $$$|      |   $$ \ |  \  |  |   $$ \  /      \ 
| $$$$\  $$$$  | $$$$\  $$$$ \$$$$$$\$$$$$$ | $$  | $$\$$$$$$ |  $$$$$$\
| $$\$$ $$ $$  | $$\$$ $$ $$/      $$| $$ __| $$  | $$ | $$ __| $$    $$
| $$ \$$$| $$__| $$ \$$$| $|  $$$$$$$| $$|  | $$__/ $$ | $$|  | $$$$$$$$
| $$  \$ | $|  | $$  \$ | $$\$$    $$ \$$  $$\$$    $$  \$$  $$\$$     \
 \$$      \$$\$$\$$      \$$ \$$$$$$$  \$$$$  \$$$$$$    \$$$$  \$$$$$$$
```
