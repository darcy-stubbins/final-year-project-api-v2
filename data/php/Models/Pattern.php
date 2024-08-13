<?php

namespace Models;

use Classes\Model;

class Pattern extends Model
{

    public function test()
    {
        return 'im firing babyyyyyy';
    }

    //function to add a pattern to the db 
    public function create(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO patterns (pattern_name, user_id, pdf_path) VALUES (?, ?, ?)");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'pattern added' => $result
        ]);
    }

    //function to show all patterns in the db 
    public function showAll()
    {
        $stmt = $this->db->prepare("SELECT p.*, u.user_name FROM patterns as p JOIN users as u ON p.user_id = u.id");
        $stmt->execute();
        $pattern = $stmt->fetchAll();

        return json_encode(
            $pattern
        );
    }

    //function to add comments to a pattern 
    public function postPatternComment(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO comments (pattern_id, user_id, comment_body) VALUES (?, ?, ?)");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'comment addded' => $result
        ]);
    }

    //function to show comments on a pattern 
    public function getPatternComments(int $id, array $data)
    {
        $stmt = $this->db->prepare("SELECT c.*, u.user_name FROM comments as c JOIN users as u ON c.user_id = u.id WHERE c.pattern_id =?");
        $stmt->execute([$id]);
        $comments = $stmt->fetchAll();

        return json_encode(
            $comments
        );
    }

    //function to add a like to a pattern 
    public function postPatternLike(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO likes (user_id, pattern_id) VALUES (?, ?)");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'pattern liked' => $result
        ]);
    }
}