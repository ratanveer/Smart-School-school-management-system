<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehroute_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null) {
        $this->db->select('vehicle_routes.*,transport_route.route_title,transport_route.fare')->from('vehicle_routes');
        $this->db->join('transport_route', 'transport_route.id = vehicle_routes.route_id');
        $this->db->group_by('vehicle_routes.route_id');
        if ($id != null) {
            $this->db->where('vehicle_routes.id', $id);
        } else {
            $this->db->order_by('vehicle_routes.id', 'DESC');
        }

        $query = $this->db->get();
        if ($id != null) {
            $vehicle_routes = $query->result_array();

            $array = array();
            if (!empty($vehicle_routes)) {
                foreach ($vehicle_routes as $vehicle_key => $vehicle_value) {
                    $vec_route = new stdClass();
                    $vec_route->id = $vehicle_value['id'];
                    $vec_route->route_title = $vehicle_value['route_title'];
                    $vec_route->fare = $vehicle_value['fare'];
                    $vec_route->route_id = $vehicle_value['route_id'];
                    $vec_route->vehicles = $this->getVechileByRoute($vehicle_value['route_id']);
                    $array[] = $vec_route;
                }
            }
            return $array;
        } else {
            $vehicle_routes = $query->result_array();
            $array = array();
            if (!empty($vehicle_routes)) {
                foreach ($vehicle_routes as $vehicle_key => $vehicle_value) {

                    $vec_route = new stdClass();
                    $vec_route->id = $vehicle_value['id'];
                    $vec_route->route_title = $vehicle_value['route_title'];
                    $vec_route->fare = $vehicle_value['fare'];
                    $vec_route->route_id = $vehicle_value['route_id'];
                    $vec_route->vehicles = $this->getVechileByRoute($vehicle_value['route_id']);
                    $array[] = $vec_route;
                }
            }
            return $array;
        }
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function getVechileByRoute($route_id) {
        $this->db->select('vehicle_routes.id as vec_route_id,vehicles.*')->from('vehicle_routes');
        $this->db->join('vehicles', 'vehicles.id = vehicle_routes.vehicle_id');

        $this->db->where('vehicle_routes.route_id', $route_id);
        $this->db->order_by('vehicle_routes.id', 'DESC');
        $query = $this->db->get();
        return $vehicle_routes = $query->result();
    }

    public function getVechileDetailByVecRouteID($id) {
        $this->db->select('vehicle_routes.id as vec_route_id,vehicles.*,transport_route.route_title')->from('vehicle_routes');
        $this->db->join('vehicles', 'vehicles.id = vehicle_routes.vehicle_id');
        $this->db->join('transport_route', 'transport_route.id = vehicle_routes.route_id');
        $this->db->where('vehicle_routes.id', $id);
        $query = $this->db->get();
        return $vehicle_routes = $query->row();
    }

    public function listroute() {

        $listroute = $this->route_model->listroute();
        if (!empty($listroute)) {
            foreach ($listroute as $route_key => $route_value) {
                $vehicles = $this->getVechileByRoute($route_value['id']);
                $listroute[$route_key]['vehicles'] = $vehicles;
            }
        }
        return $listroute;
    }

    public function remove($route_id, $array) {
        $this->db->where('route_id', $route_id);
        $this->db->where_in('vehicle_id', $array);
        $this->db->delete('vehicle_routes');
    }

    public function removeByroute($route_id) {
        $this->db->where('route_id', $route_id);
        $this->db->delete('vehicle_routes');
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('vehicle_routes', $data);
        } else {
            $this->db->insert_batch('vehicle_routes', $data);
            return $this->db->insert_id();
        }
    }

    public function route_exists($str) {
        $route_id = $this->security->xss_clean($str);
        $pre_route_id = $this->input->post('pre_route_id');
        if (isset($pre_route_id)) {
            if ($route_id == $pre_route_id) {
                return TRUE;
            }
        }

        if ($this->check_data_exists($route_id)) {
            $this->form_validation->set_message('route_exists', 'Record already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_data_exists($route_id) {
        $this->db->where('route_id', $route_id);

        $query = $this->db->get('vehicle_routes');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
