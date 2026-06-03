<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreCartItemRequest;
use App\Http\Requests\Client\UpdateCartItemRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Create the cart controller.
     *
     * @param  CartService  $cartService  Cart business service.
     * @return void
     */
    public function __construct(private readonly CartService $cartService) {}

    /**
     * Display the authenticated user cart.
     *
     * @param  Request  $request  Authenticated request.
     * @return JsonResponse Cart response.
     */
    public function show(Request $request): JsonResponse
    {
        $cart = $this->cartService->getCart($request->user());

        return response()->json([
            'cart' => $this->cartService->summary($cart),
        ]);
    }

    /**
     * Add a product to the cart.
     *
     * @param  StoreCartItemRequest  $request  Validated cart item request.
     * @return JsonResponse Cart response.
     */
    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $cart = $this->cartService->addItem(
            $request->user(),
            (string) $request->validated('produit_ref'),
            (int) $request->validated('quantity'),
        );

        return response()->json([
            'message' => 'Cart item saved.',
            'cart' => $this->cartService->summary($cart),
        ], 201);
    }

    /**
     * Update a cart item quantity.
     *
     * @param  UpdateCartItemRequest  $request  Validated cart item request.
     * @param  int  $itemId  Cart item id.
     * @return JsonResponse Cart response.
     */
    public function update(UpdateCartItemRequest $request, int $itemId): JsonResponse
    {
        $cart = $this->cartService->updateItem(
            $request->user(),
            $itemId,
            (int) $request->validated('quantity'),
        );

        return response()->json([
            'message' => 'Cart item updated.',
            'cart' => $this->cartService->summary($cart),
        ]);
    }

    /**
     * Remove one cart item.
     *
     * @param  Request  $request  Authenticated request.
     * @param  int  $itemId  Cart item id.
     * @return JsonResponse Cart response.
     */
    public function destroy(Request $request, int $itemId): JsonResponse
    {
        $cart = $this->cartService->removeItem($request->user(), $itemId);

        return response()->json([
            'message' => 'Cart item removed.',
            'cart' => $this->cartService->summary($cart),
        ]);
    }
}
