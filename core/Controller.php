<?php

class Controller
{
    public function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
