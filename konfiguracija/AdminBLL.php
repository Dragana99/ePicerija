<?php

class AdminBLL
{
    function __construct($conn, $admin)
    {
        $this->conn = $conn;
        $this->admin = $admin;
    }

    function dodajAdmina()
    {
        // poslovna logika ce da proverava da li admin ima vise od 3 slova u imenu
        if (strlen($this->admin->username) <= 3) {
            throw new Exception("Admin mora da ima username duzi od 3 karaktera");
        }
        // ako je sve ok, dodaj admina
        $this->admin->dodaj($this->conn->getConnection());
    }
}
