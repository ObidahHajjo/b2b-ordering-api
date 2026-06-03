<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BaseCrudService;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

abstract class BaseApiCrudController extends Controller
{
    /**
     * Create the base API CRUD controller.
     *
     * @param  BaseCrudService  $service  Resource service.
     * @return void
     */
    public function __construct(private readonly BaseCrudService $service) {}

    /**
     * Display all resources.
     *
     * @return JsonResponse Resource collection response.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            $this->collectionKey() => $this->transformCollection($this->service->all()),
        ]);
    }

    /**
     * Display one resource.
     *
     * @param  string  $id  Resource primary key.
     * @return JsonResponse Resource response.
     */
    public function show(string $id): JsonResponse
    {
        $resource = $this->service->getById($id);
        abort_if($resource === null, 404);

        return response()->json([
            $this->resourceKey() => $this->transformResource($resource),
        ]);
    }

    /**
     * Store a new resource.
     *
     * @param  Request  $request  Incoming request.
     * @return JsonResponse Created resource response.
     */
    public function store(Request $request): JsonResponse
    {
        $resource = $this->service->create(
            $this->validatedData($request, $this->storeRules(), $this->storeRequestClass())
        );

        return response()->json([
            'message' => ucfirst($this->resourceKey()).' created.',
            $this->resourceKey() => $this->transformResource($resource),
        ], 201);
    }

    /**
     * Update an existing resource.
     *
     * @param  Request  $request  Incoming request.
     * @param  string  $id  Resource primary key.
     * @return JsonResponse Updated resource response.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $this->validatedData($request, $this->updateRules(), $this->updateRequestClass());
        $updated = $this->service->update($id, $validated);
        abort_if(! $updated, 404);

        return response()->json([
            'message' => ucfirst($this->resourceKey()).' updated.',
            $this->resourceKey() => $this->transformResource($this->service->getById($id)),
        ]);
    }

    /**
     * Delete one resource.
     *
     * @param  string  $id  Resource primary key.
     * @return JsonResponse Deleted resource response.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->service->delete($id);
        abort_if(! $deleted, 404);

        return response()->json([
            'message' => ucfirst($this->resourceKey()).' deleted.',
        ]);
    }

    /**
     * Get the singular resource key.
     *
     * @return string Singular response key.
     */
    abstract protected function resourceKey(): string;

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    abstract protected function collectionKey(): string;

    /**
     * Get validation rules for creation.
     *
     * @return array<string, mixed> Validation rules.
     */
    abstract protected function storeRules(): array;

    /**
     * Get validation rules for update.
     *
     * @return array<string, mixed> Validation rules.
     */
    abstract protected function updateRules(): array;

    /**
     * Get the optional resource class.
     *
     * @return class-string<JsonResource>|null Resource class name.
     */
    protected function resourceClass(): ?string
    {
        return null;
    }

    /**
     * Get the optional store request class.
     *
     * @return class-string<FormRequest>|null Request class name.
     */
    protected function storeRequestClass(): ?string
    {
        return null;
    }

    /**
     * Get the optional update request class.
     *
     * @return class-string<FormRequest>|null Request class name.
     */
    protected function updateRequestClass(): ?string
    {
        return null;
    }

    /**
     * Transform one resource for JSON output.
     *
     * @param  mixed  $resource  Resource model.
     * @return mixed Transformed resource payload.
     */
    protected function transformResource(mixed $resource): mixed
    {
        $resourceClass = $this->resourceClass();

        if ($resourceClass === null) {
            return $resource;
        }

        return (new $resourceClass($resource))->resolve();
    }

    /**
     * Transform a resource collection for JSON output.
     *
     * @param  mixed  $resources  Resource collection.
     * @return mixed Transformed collection payload.
     */
    protected function transformCollection(mixed $resources): mixed
    {
        $resourceClass = $this->resourceClass();

        if ($resourceClass === null) {
            return $resources;
        }

        return $resourceClass::collection($resources)->resolve();
    }

    /**
     * Validate incoming request data.
     *
     * @param  Request  $request  Incoming request.
     * @param  array<string, mixed>  $fallbackRules  Fallback validation rules.
     * @param  class-string<FormRequest>|null  $requestClass  Optional request class.
     * @return array<string, mixed> Validated data.
     */
    protected function validatedData(Request $request, array $fallbackRules, ?string $requestClass): array
    {
        if ($requestClass === null) {
            return $request->validate($fallbackRules);
        }

        /** @var FormRequest $formRequest */
        $formRequest = $requestClass::createFrom($request, app($requestClass));
        $formRequest->setContainer(app());
        $formRequest->setRedirector(app('redirect'));
        $formRequest->validateResolved();

        return $formRequest->validated();
    }
}
