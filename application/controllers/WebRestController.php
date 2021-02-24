<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');

    if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        exit;
    }
        //required for REST API
        require(APPPATH . '/libraries/REST_Controller.php');
        require APPPATH . 'libraries/Format.php';
        use Restserver\Libraries\REST_Controller;


    class WebRestController extends REST_Controller {
        
        function __construct() {
            parent::__construct();
            $this->load->model('person_model', 'person');
        }
        
        function persons_get() {
            $persons = $this->person->get_person_list();
            if ($persons) {
                $this->response($persons, 200);
            } else {
                $this->response(array(), 200);
            }
        }
        function person_get() {
            if (!$this->get('id')) { //query parameter, example, websites?id=1
                $this->response(NULL, 400);
            }
            $person = $this->person->get_person($this->get('id'));
            if ($person) {
                $this->response($person, 200); // 200 being the HTTP response code
            } else {
                $this->response(array(), 500);
            }
        }
        
        function add_person_post() {
            $person_name = $this->post('name');
            $person_age = $this->post('age');
            $person_city = $this->post('city');
            
            $result = $this->person->add_person($person_name, $person_age, $person_city);
            if ($result === FALSE) {
                $this->response(array('status' => 'failed'));
            } else {
                $this->response(array('status' => 'success'));
            }
        }
        function update_person_put() {
            $person_id = $this->put('id');
            $person_name = $this->put('name');
            $person_age = $this->put('age');
            $person_city = $this->put('city');
            $result = $this->person->update_person($person_id, $person_name, $person_age, $person_city);
            if ($result === FALSE) {
                $this->response(array('status' => 'failed'));
            } else {
                $this->response(array('status' => 'success'));
            }
        }
        
        function delete_person_delete($person_id) { //path parameter, example, /delete/1
            $result = $this->person->delete_person($person_id);
            if ($result === FALSE) {
                $this->response(array('status' => 'failed'));
            } else {
                $this->response(array('status' => 'success'));
            }
        }
        
    }