<?php

namespace Classes;

class LoginService
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
    }


    //function to login a user and assign them a token that will be used to approve anything they do within the app
    public function login(array $data)
    {
        $data['user_password'] = hash('sha256', $data['user_password']);
        $stmt = $this->model->db->prepare("SELECT * FROM users as u WHERE user_password = ? AND user_email = ?");
        $stmt->execute([$data['user_password'], $data['user_email']]);
        $user = $stmt->fetch();

        if ($user) {
            $token = hash('sha256', time() . $data['user_password']);
            $stmt = $this->model->db->prepare("UPDATE users SET token = ?, token_expiry = (NOW() + INTERVAL 7 day) WHERE id = ?");
            $stmt->execute([$token, $user['id']]);
            return json_encode([
                'success' => true,
                'token' => $token,
            ]);
        } else {
            return json_encode([
                'success' => false,
                'message' => 'Username or passowrd is incorrect'
            ]);
        }
    }

    //function to logout the current user and clear their currently set token in the db 
    public function logout(array $data)
    {
        $stmt = $this->model->db->prepare("UPDATE users SET token_expiry = NOW() WHERE token = ?");
        $stmt->execute($data['token']);

        return json_encode([
            'success' => true,
        ]);
    }


}