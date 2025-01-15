<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $shopeeProducts = [];
        $lazadaProducts = [];
        $localProducts = [];
        
        // Only fetch Shopee products if Shopee is selected
        if ($request->shopee === 'true') {
            $shopeeProducts = $this->getShopeeProducts($keyword);
        }
        
        // Add Lazada products fetch if Lazada is selected
        if ($request->lazada === 'true') {
            $lazadaProducts = $this->getLazadaProducts($keyword);
        }
        
        // Add Local database products fetch if Local is selected
        if ($request->local === 'true') {
            // Implement local database query here
            $localProducts = $this->getLocalProducts($keyword); // Placeholder for now
        }
        
        return view('search-results', [
            'shopeeProducts' => $shopeeProducts,
            'lazadaProducts' => $lazadaProducts,
            'localProducts' => $localProducts,
            'keyword' => $keyword
        ]);
    }

    private function getShopeeProducts($keyword)
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://api.tmapi.top/shopee/search/items/v2?" . http_build_query([
                'apiToken' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VybmFtZSI6IkRleHRlckR5a2VzIiwiQ29taWQiOm51bGwsIlJvbGVpZCI6bnVsbCwiaXNzIjoidG1hcGkiLCJzdWIiOiJEZXh0ZXJEeWtlcyIsImF1ZCI6WyIiXSwiaWF0IjoxNzE5NTg2MzY0fQ.CQP8FuisiLQRsKXVMhLDCYH5e9Y6fzCfTjJ2ctvDjIA',
                'site' => 'my',
                'keyword' => $keyword,
                'by' => 'relevancy',
                'order' => 'desc',
                'page' => 1,
                'pageSize' => 10
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return [];
        }

        $data = json_decode($response, true);
        $formattedProducts = [];

        if (isset($data['data']['items'])) {
            $items = array_slice($data['data']['items'], 0, 10);
            foreach ($items as $item) {
                $formattedProducts[] = [
                    'image' => $item['img'] ?? '',
                    'title' => $item['title'] ?? 'No title',
                    'price' => $item['price_info']['price'] ?? '0.00',
                    'brand' => $item['brand'] ?? 'No brand',
                    'discount' => $item['discount'] ?? 0,
                    'liked_count' => $item['liked_count'] ?? 0,
                    'comment_count' => $item['comment_count'] ?? 0,
                    'shop_name' => $item['shop_info']['name'] ?? 'Unknown Shop',
                    'item_url' => "https://shopee.com.my/product/{$item['shop_id']}/{$item['item_id']}"
                ];
            }
        }

        return $formattedProducts;
    }

    private function getLazadaProducts($keyword)
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://api.tmapi.top/lazada/search/items?" . http_build_query([
                'apiToken' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VybmFtZSI6IkRleHRlckR5a2VzIiwiQ29taWQiOm51bGwsIlJvbGVpZCI6bnVsbCwiaXNzIjoidG1hcGkiLCJzdWIiOiJEZXh0ZXJEeWtlcyIsImF1ZCI6WyIiXSwiaWF0IjoxNzE5NTg2MzY0fQ.CQP8FuisiLQRsKXVMhLDCYH5e9Y6fzCfTjJ2ctvDjIA',
                'site' => 'my',
                'keywords' => $keyword,
                'sort' => 'pop',
                'page' => 1
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return [];
        }

        $data = json_decode($response, true);
        $formattedProducts = [];

        if (isset($data['data']['items'])) {
            $items = array_slice($data['data']['items'], 0, 10);
            foreach ($items as $item) {
                $formattedProducts[] = [
                    'image' => $item['img'] ?? '',
                    'title' => $item['title'] ?? 'No title',
                    'price' => $item['price_info']['sale_price'] ?? $item['price'] ?? '0.00',
                    'brand' => $item['brand'] ?? 'No brand',
                    'discount' => $item['discount'] ?? 0,
                    'liked_count' => $item['review_info']['review_count'] ?? 0,
                    'comment_count' => $item['comment_count'] ?? 0,
                    'shop_name' => $item['shop_info']['shop_name'] ?? 'Unknown Shop',
                    'item_url' => $item['product_url'] ?? '#'
                ];
            }
        }

        return $formattedProducts;
    }

    private function getLocalProducts($keyword)
    {
        $products = Product::where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('brand', 'LIKE', "%{$keyword}%")
            ->latest()
            ->limit(10)
            ->get();

        return $products->map(function($product) {
            return [
                'image' => $product->img_link,
                'title' => $product->title,
                'price' => $product->price,
                'brand' => $product->brand,
                'item_url' => $product->product_link,
            ];
        })->toArray();
    }
}