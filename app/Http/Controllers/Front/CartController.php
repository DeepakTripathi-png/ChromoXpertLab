<?php
    namespace App\Http\Controllers\Front;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Cart;
    use App\Models\Test;

    class CartController extends Controller
    {
        public function index()
        {
            $userId = Auth::id();

            $cartItems = Cart::with('test') // eager load the related test
                        ->where('user_id', $userId)
                        ->get();
            return view('Front.cart',compact('cartItems'));
        }
        public function addToCart(Request $request)
        {
            $request->validate([
                'test_id' => 'required|exists:tests,id',
            ]);

            $userId = Auth::id();

            // check if test already exists in cart
            $exists = Cart::where('user_id', $userId)
                ->where('test_id', $request->test_id)
                ->first();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Test already in cart.'
                ]);
            }

            $test = Test::find($request->test_id);

            Cart::create([
                'user_id' => $userId,
                'test_id' => $test->id,
                'price' => $test->total_price,
                'quantity' => 1
            ]);
            $count = Cart::where('user_id', $userId)->count();
            return response()->json([
                'success' => true,
                'message' => 'Test added to cart successfully.',
                'cartCount' => $count
            ]);
        }
        public function remove($id)
        {
            $cart = Cart::findOrFail($id);
            $cart->delete();

            $count = Cart::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'cartCount' => $count
            ]);
        }
    }
?>