<?php
class Model {
    public $db;
    public function __construct(){
        $this->db = new mysqli("localhost", "project", "password", "eschool", 3306);
        if ($this->db->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->db->connect_errno . ") " . 
                $this->db->connect_error;
        }
		/* change character set to utf8 */
		if (!$this->db->set_charset("utf8")) {
			printf("Error loading character set utf8: %s\n", $this->db->error);
			exit();
		}
    }
}
