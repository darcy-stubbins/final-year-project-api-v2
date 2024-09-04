<?php

namespace Models;

use Classes\Model;

class User extends Model
{
    //function to add an account to the db 
    public function createUser(array $data)
    {
        //hashing the password 
        $data['user_password'] = hash('sha256', $data['user_password']);

        $stmt = $this->db->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
        $result = $stmt->execute([$data['user_name'], $data['user_email'], $data['user_password']]);

        return json_encode([
            'success' => true,
            'message' => 'user created'
        ]);
    }

    //function to show a user by id 
    public function showUser(array $data)
    {
        $stmt = $this->db->prepare("SELECT u.* FROM users as u WHERE id=?");
        $stmt->execute([$data['user_id']]);
        $user = $stmt->fetch();

        return json_encode(
            $user
        );
    }

    //function to remove an account from the db 
    public function deleteUser(array $data)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'success' => true,
            'message' => 'user deleted'
        ]);
    }

    //function to add a pattern into the saved table in the db 
    public function postSavePattern(array $data)
    {
        $stmt = $this->db->prepare("SELECT * FROM saved as s WHERE s.user_id=? AND s.pattern_id=?");
        $stmt->execute([$data['user_id'], $data['pattern_id']]);
        $saved = $stmt->fetchAll();

        if (empty($saved)) {
            $stmt = $this->db->prepare("INSERT INTO saved (user_id, pattern_id) VALUES (?, ?)");
            $message = 'pattern saved';
        } else {
            $stmt = $this->db->prepare("DELETE FROM saved WHERE user_id=? AND pattern_id=?");
            $message = 'pattern unsaved';
        }

        $result = $stmt->execute([$data['user_id'], $data['pattern_id']]);

        return json_encode([
            'success' => $result,
            'message' => $message
        ]);
    }

    //function to return list of users saved patterns 
    public function getSavedPatterns($data)
    {
        $stmt = $this->db->prepare("SELECT p.id, p.pattern_name, p.pdf_path, u.user_name, CASE WHEN(SELECT pattern_id FROM saved WHERE user_id = ? AND pattern_id = p.id) IS NULL THEN 0 ELSE 1 END AS saved, CASE WHEN(SELECT pattern_id FROM likes WHERE user_id = ? AND pattern_id = p.id) IS NULL THEN 0 ELSE 1 END AS liked FROM patterns as p JOIN users as u ON u.id = p.user_id JOIN saved as s ON p.id = s.pattern_id WHERE s.user_id=?");
        $stmt->execute([$data['user_id'], $data['user_id'], $data['user_id']]);
        $saved = $stmt->fetchAll();

        return json_encode(
            $saved
        );
    }

    //creating friend functionality 
    public function addFriend(array $data)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_name LIKE ?");
        $stmt->execute([$data['friend_request']]);
        $friend = $stmt->fetch();

        if ($friend) {
            $stmt = $this->db->prepare("INSERT INTO friends (friend_id, user_id) VALUES (?, ?)");
            $result = $stmt->execute([$friend['id'], $data['user_id']]);

            return json_encode([
                'success' => true,
                'message' => 'friend added'
            ]);
        }

        return json_encode([
            'success' => false,
            'message' => 'friend not found'
        ]);
    }

    //function to return the users list of friends 
    public function getFriendsList(array $data)
    {
        $stmt = $this->db->prepare("SELECT u.* FROM users as u WHERE
	        u.id IN (SELECT friend_id FROM friends WHERE user_id = ?) OR 
	        u.id IN (SELECT user_id FROM friends WHERE friend_id = ?)");
        $stmt->execute([$data['user_id'], $data['user_id']]);
        $friends = $stmt->fetchAll();

        return json_encode(
            $friends
        );
    }
}