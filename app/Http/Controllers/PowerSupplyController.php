<?php

namespace App\Http\Controllers;

use App\Http\Requests\PowerSupplyRequest;
use App\Http\Resources\PowerSupplyResource;
use App\Models\PowerSupply;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PowerSupplyController extends Controller
{

    /**
     * Create a new PowerSupplyController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Retrieve all UPSs.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): AnonymousResourceCollection
    {
        return PowerSupplyResource::collection(
            PowerSupply::query()
            ->when(request('search'), function ($query) {
                $query->search(request('search'))
                    ->orderBy('relevance', 'DESC');
            })->get()
        );
    }


    /**
     * Create new UPS.
     *
     * @param Request $request
     * @return PowerSupplyResource
     */
    public function create(PowerSupplyRequest $request): PowerSupplyResource
    {
        $item = PowerSupply::create($request->all());
        return (new PowerSupplyResource($item));
    }


    /**
     * Update existing UPS.
     *
     * @param Request $request
     * @param $id
     * @return PowerSupplyResource
     */
    public function update(PowerSupplyRequest $request, $id): PowerSupplyResource
    {

        $ups = PowerSupply::whereId($id)
            ->firstOrFail();

        $ups->update($request->all());

        return (new PowerSupplyResource($ups));

    }


    /**
     * Delete UPS by id.
     *
     * @param $id
     * @return PowerSupplyResource
     */
    public function delete($id): PowerSupplyResource
    {
        $ups = PowerSupply::whereId($id)
            ->firstOrFail();

        $ups->delete();

        return (new PowerSupplyResource($ups));

    }


    /**
     * Get one UPS.
     *
     * @param $id
     * @return PowerSupplyResource
     */
    public function get($id): PowerSupplyResource
    {
        $ups = PowerSupply::whereId($id)
            ->firstOrFail();

        return (new PowerSupplyResource($ups));
    }

}
