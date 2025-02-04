<?php

namespace App\Http;
use App\Models\Order;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Monolog\Logger;
use Exception;

class OrderFetcher
{
    protected Client $client;
    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->client = new Client();
        $this->logger = $logger;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function fetchAndStore(): void
    {
        $page = 1;
        $totalPagesCount = 2;

        [$url, $token] = $this->getHttpCredentials();

        while ($page <= $totalPagesCount) {
            try {
                $response = $this->fetchOrders($url, $token, $page);
                $orders = $response['orders'];
                $this->saveOrders($orders);
                $totalPagesCount = $response['pagination']['totalPageCount'];

                $this->logger->info("Fetched orders", [
                    'page: ' => $response['pagination']['currentPage'],
                ]);
                dump('current page: ' . $page);

                $page++;
                sleep(1);

            } catch (Exception $e) {
                $this->logger->error("API request failed: " . $e->getMessage());
            }
        }

    }

    /**
     * @throws Exception
     */
    private function getHttpCredentials(): array
    {
        $url = env('API_URL');
        $token = env('API_TOKEN');
        if(!$url || !$token) {
            $this->logger->error("API_URL or API_TOKEN is not set");
            throw new Exception("API_URL or API_TOKEN is not set");
        }
        return [$url, $token];
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    private function fetchOrders(string $url, string $token, int $page): array
    {
        $query = http_build_query([
            'apiKey' => $token,
            'page' => $page,
        ]);

        try{
            $response = $this->client->get($url . '/api/v5/orders?'. $query , [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody(), true);

        }catch (Exception $e) {
            $this->logger->error("API request failed: " . $e->getMessage());
            throw $e;
        }
    }

    private function saveOrders(array $orders): void
    {
        $dataToSave = [];
        foreach ($orders as $order) {
            $dataToSave[] = [
                'order_id' => $order['id'],
                'customer_id' => $order['customer']['id'],
                'order_number' => $order['number'],
                'order_date' => Carbon::make($order['customFields']['vremia_postupleniia_zakaza']),
                'date_of_sale' => Carbon::make($order['customFields']['fakt_data']),
                'sum' => $order['totalSumm'],
                'prepay_sum' => $order['prepaySum'],
            ];
        }
        Order::query()->upsert($dataToSave, ['order_id'], ['sum', 'prepay_sum']);
    }
}