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
    public function createPattern(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO patterns (pattern_name, user_id, pdf_path) VALUES (?, ?, ?)");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'pattern added' => $result
        ]);
    }

    //function to show all patterns in the db 
    public function showAllPatterns()
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
    public function getPatternComments(int $id)
    {
        $stmt = $this->db->prepare("SELECT c.*, u.user_name FROM comments as c LEFT JOIN users as u ON c.user_id = u.id WHERE c.pattern_id=?");
        $stmt->execute([$id]);
        $comments = $stmt->fetchAll();

        return json_encode(
            $comments
        );
    }

    // public function getAllComments()
    // {
    //     $stmt = $this->db->prepare("SELECT c.*, u.user_name FROM comments as c LEFT JOIN users as u ON c.user_id = u.id");
    //     $stmt->execute();
    //     $comments = $stmt->fetchAll();

    //     return json_encode(
    //         $comments
    //     );
    // }

    //function to add a like to a pattern 
    public function postPatternLike(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO likes (pattern_id, user_id) VALUES (?, ?)");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'pattern liked' => $result
        ]);
    }

    //function to remove a like on a pattern 
    public function removePatternLike(array $data)
    {
        $stmt = $this->db->prepare("DELETE FROM likes WHERE pattern_id=? AND user_id=?");
        $result = $stmt->execute(array_values($data));

        return json_encode([
            'pattern unliked' => $result
        ]);
    }

    //creating pattern search functionality for the searh bar
    public function search(array $data)
    {
        $data['search_term'] = '%' . $data['search_term'] . '%';
        $stmt = $this->db->prepare("SELECT p.*, u.user_name FROM patterns as p JOIN users as u ON p.user_id = u.id WHERE pattern_name LIKE ?");
        $stmt->execute(array_values($data));
        $searchResult = $stmt->fetchAll();

        return json_encode(
            $searchResult
        );
    }
}