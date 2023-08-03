<?php

namespace App\Models;

use Core\Database\Database;
use Core\Application as App;
use Core\ErrorBag;
use Core\Validator;
use JetBrains\PhpStorm\NoReturn;

class AppModel extends Model
{
    public function addNote($title, $body, $userId)
    {
        $this->db->insert('note',
            [
                'title' => $title,
                'body' => $body,
                'user_id' => $userId
            ]);
    }
    public function getNote(array $filters): bool|array
    {
        return $this->db->selectWhere('note', '=', $filters);
    }
    public function getNotes(string $filters, array $params = []): bool|array
    {
        return $this->db->selectAll('note', $filters, $params);
    }

    public function getComments(string $filters, array $params = []): bool|array
    {
        return $this->db->selectAll('comments', $filters, $params);
    }
    #[NoReturn] public function saveNote($title, $body, $currentUserId)
    {
        $this->addNote($title, $body, $currentUserId);
        redirect("/notes");
    }

    #[NoReturn] public function deleteNote(array $params)
    {
        $this->db->delete('note', $params);
        redirect("/notes");
    }

    #[NoReturn] public function addComment($comment, $noteId, $userId)
    {
        $this->db->insert('comments', [
            'body' => $comment,
            'note_id' => $noteId,
            'user_id' => $userId
        ]);

        previousUrl();
    }

    #[NoReturn] public function deleteComment(array $params)
    {
        $this->db->delete('comments', $params);
        previousUrl();
    }
}