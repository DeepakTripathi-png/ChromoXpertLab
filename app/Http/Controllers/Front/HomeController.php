<?php 
    namespace App\Http\Controllers\Front;
    use App\Http\Controllers\Controller;
    class HomeController extends Controller
    {
        public function index()
        {
            return view('Front.home');
        }
        public function getCartCount()
        {
            if (auth()->check()) {
                $userId = auth()->id();

                // Get count and list of test IDs
                $cartItems = \App\Models\Cart::where('user_id', $userId)->pluck('test_id');
                $count = $cartItems->count();

                return response()->json([
                    'cartCount' => $count,
                    'testIds' => $cartItems, // ✅ return test IDs too
                ]);
            }

            return response()->json([
                'cartCount' => 0,
                'testIds' => [],
            ]);
        }
    }
?>