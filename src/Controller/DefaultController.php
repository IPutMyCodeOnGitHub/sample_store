<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->json([
            'routes' => [
                'catalog' => [
                    'categories' => [
                        'path' => 'GET catalog/categories',
                        'description' => 'Returns a list of categories'
                    ],
                    'products' => [
                        'path' => 'GET /catalog/products',
                        'description' => 'Returns a list of products'
                    ]
                ],
                'user' => [
                    'profile' => [
                        'path' => 'GET /my/profile',
                        'description' => 'Returns profile data of authorized user'
                    ],
                    'orders' => [
                        'path' => 'GET /my/orders',
                        'description' => 'Returns orders list of authorized user'
                    ]
                ]
            ]
        ]);
    }
}
