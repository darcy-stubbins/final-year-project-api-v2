<?php

namespace Models;

use Classes\Model;
use PDO;

class User extends Model
{
    //function to add an account to the db 
    public function create(array $data)
    {
        //hashing the password 
        $data['user_password'] = password_hash($data['user_password'], PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'account added' => $result
        ]);
    }

    //function to show a user by id 
    public function show(int $id)
    {
        $stmt = $this->db->prepare("SELECT u.user_name, u.user_email, u.user_password FROM users as u WHERE id=?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        return json_encode(
            $user
        );
    }

    //function to remove an account from the db 
    public function delete(array $data)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'account deleted' => $result
        ]);
    }

    //function to add a pattern into the saved table in the db 
    public function postSavePattern(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO saved (user_id, pattern_id) VALUES (?, ?)");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'pattern added' => $result
        ]);
    }

    //function to return list of users saved patterns 
    public function getSavedPatterns(int $id, array $data)
    {
        $stmt = $this->db->prepare("SELECT p.id, p.pattern_name, p.pdf_path FROM patterns as p JOIN saved ON p.id = saved.pattern_id WHERE saved.user_id=?");
        $stmt->execute([$id]);
        $saved = $stmt->fetchAll();

        return json_encode(
            $saved
        );
    }
}