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
        $result = $stmt->execute([$data['pattern_id'], $data['user_id'], $data['comment_body']]);

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

    //function to add a like to a pattern 
    public function postPatternLike(array $data)
    {
        $stmt = $this->db->prepare("SELECT * FROM likes as l WHERE l.user_id=? AND l.pattern_id=?");
        $stmt->execute([$data['user_id'], $data['pattern_id']]);
        $likes = $stmt->fetchAll();

        if (empty($likes)) {
            $stmt = $this->db->prepare("INSERT INTO likes (user_id, pattern_id) VALUES (?, ?)");
            $message = 'pattern liked';
        } else {
            $stmt = $this->db->prepare("DELETE FROM likes WHERE user_id=? AND pattern_id=?");
            $message = 'pattern unliked';
        }

        $result = $stmt->execute([$data['user_id'], $data['pattern_id']]);

        return json_encode([
            $message => $result
        ]);
    }

    //creating pattern search functionality for the searh bar
    public function search(array $data)
    {
        $data['search_term'] = '%' . $data['search_term'] . '%';
        $stmt = $this->db->prepare("SELECT p.*, u.user_name, CASE WHEN(SELECT pattern_id FROM saved WHERE user_id = ? AND pattern_id = p.id) IS NULL THEN 0 ELSE 1 END AS saved, CASE WHEN(SELECT pattern_id FROM likes WHERE user_id = ? AND pattern_id = p.id) IS NULL THEN 0 ELSE 1 END AS liked FROM patterns as p JOIN users as u ON p.user_id = u.id WHERE pattern_name LIKE ?");
        $stmt->execute([$data['user_id'], $data['user_id'], $data['search_term']]);
        $searchResult = $stmt->fetchAll();

        return json_encode(
            $searchResult
        );
    }
}