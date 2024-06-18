<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\TransactionService;

class HomeController
{

  public function __construct(private TemplateEngine $view, private TransactionService $transactionService)
  {
  }

  public function home()
  {
    $page = $_GET['p'] ?? 1;
    $length = 3;
    $offset = ((int)$page - 1) * $length;
    [$transactions, $count] = $this->transactionService->getUserTransactions($length, $offset);
    $searchTerm = $_GET['s'] ?? null;
    $lastPage = ceil($count / $length);
    $pages = $lastPage ? range(1, $lastPage) : [];

    $pageLinks = array_map(
      fn ($pageNum) => http_build_query([
        'p' => $pageNum,
        's' => $searchTerm
      ]),
      $pages
    );

    echo $this->view->render('index.php', [
      'transactions' => $transactions,
      'currentPage' => $page,
      'previousPageQuery' => http_build_query([
        'p' => $page - 1,
        's' => $searchTerm
      ]),
      'lastPage' => $lastPage,
      'nextPageQuery' => http_build_query([
        'p' => $page + 1,
        's' => $searchTerm
      ]),
      'pageLinks' => $pageLinks,
      'searchTerm' => $searchTerm
    ]);
  }
}