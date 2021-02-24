<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Person_model extends CI_Model {
    private $person = 'person';
    
    function get_person_list() {
        $query = $this->db->get($this->person);
        if ($query) {
            return $query->result();
        }
        return NULL;
    }
    function get_person($id) {
        $query = $this->db->get_where($this->person, array("id" => $id));
        if ($query) {
            return $query->row();
        }
        return NULL;
    }
    
    function add_person($person_name, $person_age, $person_city) {
        $data = array('name' => $person_name, 'age' => $person_age, 'city' => $person_city);
        $this->db->insert($this->person, $data);
    }
    function update_person($person_id, $person_name, $person_age, $person_city) {
        $data = array('name' => $person_name, 'age' => $person_age, 'city' => $person_city);
        $this->db->where('id', $person_id);
        $this->db->update($this->person, $data);
    }
    
    function delete_person($person_id) {
        $this->db->where('id', $person_id);
        $this->db->delete($this->person);
    }
}