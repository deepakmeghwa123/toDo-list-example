<?php
namespace App\Filters;

use CodeIgimplementsniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter extends FilterInterface
{
    public function before(RequestInterface $request)
    {
        $session = session();
        $user = $session->get('user');
        
        if (!$user)
        {
            return redirect()->to(base_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do nothing
    }
}


?>