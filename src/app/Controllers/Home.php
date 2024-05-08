<?php

namespace App\Controllers;

use App\Models\CommentModel;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class Home extends BaseController
{
	private const EMAIL_PATTERN = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    public function index(): string
    {
        return view('comments');
    }

    public function fetch(): string
    {
        $model = new CommentModel();
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
    public function create(): ResponseInterface
    {
        $model = new CommentModel();
        $data = [
            'user_email' => $this->request->getPost('user_email'),
            'comment_text' => $this->request->getPost('comment_text'),
            'created_at' => date("Y-m-d H:i:s")
        ];
		if (!$this->validateEmail($data['user_email'])) {
			return $this->response->setJSON([
				'error' => 'Invalid Email',
			]);
		}
        $model->insert($data);
        return $this->response->setJSON($data);
    }

	private function validateEmail(string $email): bool
	{
		return preg_match(self::EMAIL_PATTERN, $email);
	}
    public function delete($id): ResponseInterface
    {
        $model = new CommentModel();
        $model->delete($id);
        return $this->response->setStatusCode(200, 'Comment Deleted');
    }
}
