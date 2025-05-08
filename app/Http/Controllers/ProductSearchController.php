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
        
        // // Read JSON file
        // $jsonData = file_get_contents(public_path('json/shopee_data.json'));
        // $products = json_decode($jsonData, true);
        
        // // Filter products based on keyword (case-insensitive)
        // $filteredProducts = array_filter($products, function($product) use ($keyword) {
        //     return stripos($product['title'], $keyword) !== false || 
        //            stripos($product['brand'], $keyword) !== false;
        // });

        // return array_values($filteredProducts); // Reset array keys
        

        /* API Implementation */
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://api.tmapi.top/shopee/search/items/v2?" . http_build_query([
                'apiToken' => env('SHOPEE_API_TOKEN'),
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
        
        // // Read JSON file
        // $jsonData = file_get_contents(public_path('json/lazada_data.json'));
        // $products = json_decode($jsonData, true);
        
        // // Filter products based on keyword (case-insensitive)
        // $filteredProducts = array_filter($products, function($product) use ($keyword) {
        //     return stripos($product['title'], $keyword) !== false || 
        //            stripos($product['brand'], $keyword) !== false;
        // });

        // return array_values($filteredProducts); // Reset array keys
        

        /* API Implementation */
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://lazada-api.p.rapidapi.com/lazada/search/items?" . http_build_query([
                'keywords' => $keyword,
                'site' => 'my',
                'page' => 1,
                'sort' => 'pop'
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: lazada-api.p.rapidapi.com",
                "x-rapidapi-key: " . env('LAZADA_API_KEY')
            ],
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