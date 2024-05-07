<?php

namespace App\Controllers;

use App\Models\CommentModel;
use ReflectionException;

class Home extends BaseController
{
    public function index(): string
    {
        return view('comments');
    }

    public function fetch(): string
    {
        $model = new CommentModel();
        $model->orderBy('created_at', 'DESC');

        $page = $this->request->getVar('page') ?? 1;
        $model->paginate(3);
        $pager = $model->pager;
        $comments = $model->paginate(3, 'group1', $page);

        $data = [
            'comments' => $comments,
            'pager' => $pager,
        ];

        return view('comments_table', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function create()
    {
        $model = new CommentModel();
        $data = [
            'user_email' => $this->request->getPost('user_email'),
            'comment_text' => $this->request->getPost('comment_text'),
            'created_at' => date("Y-m-d H:i:s")
        ];
        $model->insert($data);
        return $this->response->setJSON($data);
    }

    public function delete($id)
    {
        $model = new CommentModel();
        $model->delete($id);
        return $this->response->setStatusCode(200, 'Comment Deleted');
    }
}
