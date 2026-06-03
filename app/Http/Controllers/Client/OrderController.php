<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Services\OrderService;
use App\Services\ShippingCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create the order controller.
     *
     * @param  OrderService  $orderService  Order business service.
     * @param  ShippingCalculatorService  $shippingCalculator  Shipping calculator.
     * @return void
     */
    public function __construct(
        private readonly OrderService $orderService,
        private readonly ShippingCalculatorService $shippingCalculator
    ) {}

    /**
     * Display the authenticated user orders.
     *
     * @param  Request  $request  Authenticated request.
     * @return JsonResponse Order list response.
     */
    public function index(Request $request): JsonResponse
    {
        $orders = $this->orderService->userOrders($request->user())
            ->map(fn (Commande $order): array => $this->serializeOrder($order))
            ->values();

        return response()->json([
            'orders' => $orders,
        ]);
    }

    /**
     * Place an order from the authenticated user cart.
     *
     * @param  Request  $request  Authenticated request.
     * @return JsonResponse Created order response.
     */
    public function store(Request $request): JsonResponse
    {
        $order = $this->orderService->checkout($request->user());

        return response()->json([
            'message' => 'Order placed.',
            'order' => $this->serializeOrder($order),
        ], 201);
    }

    /**
     * Display one authenticated user order.
     *
     * @param  Request  $request  Authenticated request.
     * @param  int  $numero  Order number.
     * @return JsonResponse Order response.
     */
    public function show(Request $request, int $numero): JsonResponse
    {
        $order = $this->orderService
            ->userOrders($request->user())
            ->firstWhere('numero', $numero);

        abort_if($order === null, 404);

        return response()->json([
            'order' => $this->serializeOrder($order),
        ]);
    }

    /**
     * Serialize one order response.
     *
     * @param  Commande  $order  Order model.
     * @return array<string, mixed> Order payload.
     */
    private function serializeOrder(Commande $order): array
    {
        $items = $order->lignes->map(function ($line): array {
            $unitPrice = (float) $line->prix_unitaire;
            $weight = (float) $line->produit->poids;

            return [
                'id' => $line->id,
                'quantity' => $line->qte,
                'unit_price' => $unitPrice,
                'line_total' => round($unitPrice * $line->qte, 2),
                'product' => [
                    'ref' => $line->produit->ref,
                    'nom' => $line->produit->nom,
                    'poids' => $weight,
                ],
                'line_weight' => round($weight * $line->qte, 2),
            ];
        })->values();

        $subtotal = (float) $items->sum('line_total');
        $weight = (float) $items->sum('line_weight');
        $shipping = $this->shippingCalculator->calculate($weight);

        return [
            'numero' => $order->numero,
            'statut' => $order->statut,
            'date_creation' => $order->date_creation?->toISOString(),
            'date_validation' => $order->date_validation?->toISOString(),
            'items' => $items,
            'subtotal' => round($subtotal, 2),
            'shipping_total' => round($shipping, 2),
            'grand_total' => round($subtotal + $shipping, 2),
        ];
    }
}
