<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelExpensesRequest;
use App\Http\Resources\TravelExpensesResource;
use App\Models\TravelExpenses;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TravelExpensesController extends Controller
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
     * Retrieve all Road Expenses.
     *
     * @return AnonymousResourceCollection
     */
    public function all(): AnonymousResourceCollection
    {
        return TravelExpensesResource::collection(
            TravelExpenses::query()
                ->when(request('search'), function ($query) {
                    $query->search(request('search'))
                        ->orderBy('relevance', 'DESC');
                })->get()
        );
    }


    /**
     * Retrieve one Travel Destination (with its expenses).
     *
     * @param $id
     * @return TravelExpensesResource
     */
    public function get($id): TravelExpensesResource
    {
        $road_expense = TravelExpenses::whereId($id)
            ->firstOrFail();

        return (new TravelExpensesResource($road_expense));
    }


    /**
     * Retrieve all Road Expenses.
     *
     * @param $id
     * @return TravelExpensesResource
     */
    public function delete($id): TravelExpensesResource
    {
        $road_expense = TravelExpenses::whereId($id)
            ->firstOrFail();

        $road_expense->delete();

        return (new TravelExpensesResource($road_expense));
    }


    /**
     * Create new Travel Destination.
     *
     * @param Request $request
     * @return TravelExpensesResource
     */
    public function create(TravelExpensesRequest $request): TravelExpensesResource
    {
        $item = TravelExpenses::create($request->all());
        return (new TravelExpensesResource($item));
    }


    /**
     * Update Travel Destination.
     *
     * @param Request $request
     * @param $id
     * @return TravelExpensesResource
     */
    public function update(TravelExpensesRequest $request, $id): TravelExpensesResource
    {
        $road_expense = TravelExpenses::whereId($id)
            ->firstOrFail();
        $road_expense->update($request->all());

        return (new TravelExpensesResource($road_expense));
    }

}
