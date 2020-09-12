<?php

/**
 * Script Installer
 */
ini_set('max_execution_time', 0);
class Installer
{
    private $db;
    public function __construct()
    {
        $this->db = new Base;
    }

    public function deployment($byteCode)
    {
        $this->db->query($byteCode);
        if ($this->db->execute()):
            return false;
        else:
            return true;
        endif;
    }
}
