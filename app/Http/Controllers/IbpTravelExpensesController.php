<?php

namespace App\Http\Controllers;

use App\Http\Requests\IbpTravelExpensesRequest;
use App\Http\Resources\IbpTravelExpensesResource;
use App\Models\IbpTravelExpenses;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IbpTravelExpensesController extends Controller
{

    /**
     * Create a new IbpTravelExpenses instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Create a new order
     *
     * @param IbpTravelExpensesRequest $request
     * @return IbpTravelExpensesResource
     */
    public function create(IbpTravelExpensesRequest $request): IbpTravelExpensesResource
    {
        $request['user_id'] = auth()->id();

        $item = IbpTravelExpenses::create($request->all());
        return (new IbpTravelExpensesResource($item));
    }

    /**
     * Show all created orders
     *
     * @return AnonymousResourceCollection
     */
    public function all(): AnonymousResourceCollection
    {
        $user_id = auth()->id();
        $role = auth()->user()->role;

        $item = IbpTravelExpenses::query();

        if ($role == 'ordinary')
            $item->where('user_id', '=', $user_id);

        $item = $item->when(request('search'), function ($query) {
            $query->search(request('search'))
                ->orderBy('relevance', 'DESC');
        })->get();

        return IbpTravelExpensesResource::collection($item);
    }


    /**
     * Show one specified order
     *
     * @param $id
     * @return IbpTravelExpensesResource
     */
    public function get($id): IbpTravelExpensesResource
    {
        $user_id = auth()->id();
        $role = auth()->user()->role;

        $item = IbpTravelExpenses::whereId($id);

        if ($role == 'ordinary')
            $item->where('user_id', '=', $user_id);

        $item = $item->firstOrFail();

        return (new IbpTravelExpensesResource($item));
    }


    /**
     * Change an order
     *
     * @param IbpTravelExpensesRequest $request
     * @param $id
     * @return IbpTravelExpensesResource
     */
    public function change(IbpTravelExpensesRequest $request, $id): IbpTravelExpensesResource
    {
        $user_id = auth()->id();
        $role = auth()->user()->role;

        $item = IbpTravelExpenses::whereId($id);

        if ($role == 'ordinary')
            $item->where('user_id', '=', $user_id);

        $item = $item->firstOrFail();

        $item->update($request->all());

        return (new IbpTravelExpensesResource($item));
    }


    /**
     * Delete an order
     *
     * @param $id
     * @return IbpTravelExpensesResource
     */
    public function delete($id): IbpTravelExpensesResource
    {
        $user_id = auth()->id();
        $role = auth()->user()->role;

        $item = IbpTravelExpenses::whereId($id);

        if ($role == 'ordinary')
            $item->where('user_id', '=', $user_id);

        $item = $item->firstOrFail();
        $item->delete();

        return (new IbpTravelExpensesResource($item));
    }

}
