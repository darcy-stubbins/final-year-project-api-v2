<?php

namespace Classes;

class LoginService
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
    }


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


}