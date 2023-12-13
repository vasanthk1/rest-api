<?php

use Models\User;
use Core\Cache;

class UserController extends Controller
{
    private $cache;

    public function __construct()
    {
        $this->cache = new Cache();

        $this->userData = $this->cache->get("user_all");

        if(empty(json_decode($this->userData, true))) {
            $users = User::all();
            $users = json_encode($users);

            $this->cache->put("user_all", $users, 10);
        }
    }

    public function index()
    {
        // Check if the user data is cached
        $users = User::all();
        $this->jsonResponse($users);
    }

    public function show($id)
    {
        $user = User::find($id);
        $this->jsonResponse($user);
    }

    public function show_by_row_id($id) {
        $user = new User();
        $user = $user->find_by_row_id($id);
        $this->jsonResponse($user);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = new User($data);
        $user->save();
        $this->jsonResponse(['message' => 'User created successfully']);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = new User();
        if(!empty($user->find($id))) {
            $user->update($data, $id);
            $this->jsonResponse(['message' => 'User updated successfully']);
        }
        else {
            $this->jsonResponse(['message' => 'User not found']);
        }
    }

    public function destroy($id)
    {
        $user = new User();
        if(!empty($user->find($id))) {
            $user->destroy($id);
            $this->jsonResponse(['message' => 'User deleted successfully']);
        }
        else {
            $this->jsonResponse(['message' => 'User not found']);
        }
    }
}
