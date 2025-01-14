<?php

declare(strict_types=1);

class UserController
{
    private $users = [];

    public function handleRequest($request, $response)
    {
        if ($request->server['request_method'] === 'GET') {
            return $this->get($request, $response);
        } elseif ($request->server['request_method'] === 'POST') {
            return $this->post($request, $response);
        } else {
            return $this->sendJson($response, ['error' => 'Method not allowed'], 405);
        }
    }

    public function get($request, $response)
    {
        $id = $request->get['id'] ?? null;
        if ($id === null) {
            return $this->sendJson($response, $this->users);
        }

        if (isset($this->users[$id])) {
            return $this->sendJson($response, $this->users[$id]);
        }

        return $this->sendJson($response, ['error' => 'User not found'], 404);
    }

    public function post($request, $response)
    {
        $id = count($this->users);
        $data = $request->post;
        $data['id'] = $id;
        $this->users[$id] = $data;
        return $this->sendJson($response, $data, 201);
    }

    private function sendJson($response, $data, $status = 200) {
        $response->status($status);
        $response->header('Content-Type', 'application/json');
        $response->end(json_encode($data));
    }
}
