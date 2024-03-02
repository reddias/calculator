<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $id;

    /**
     * Create a new User instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('moderator', ['except' => ['changePassword', 'update']]);
    }


    /**
     * Create a new user
     * Default password is password123
     *
     * @param UserRequest $request
     * @return UserResource
     */
    public function create(UserRequest $request): UserResource
    {
        $request['password'] = 'password123';

        $item = User::create($request->all());
        return (new UserResource($item));
    }


    /**
     * Get a specified user
     * Only for moderators
     *
     * @param $id
     * @return UserResource
     */
    public function get($id): UserResource
    {
        $user = User::whereId($id)
            ->firstOrFail();

        return (new UserResource($user));
    }

    /**
     * Get all users
     * Only for moderators
     *
     * @return AnonymousResourceCollection
     */
    public function all(): AnonymousResourceCollection
    {
        return (UserResource::collection(User::all()));
    }


    /**
     * Update the User
     * For Everyone
     *
     * @param UserRequest $request
     * @param $id
     * @return JsonResponse|UserResource
     */
    public function update(Request $request, $id): JsonResponse|UserResource
    {
        $this->id = auth()->id();
        $this->role = auth()->user()->role;

        if ($this->id != $id && $this->role == 'ordinary') {
            return response()->json([
                'message' => __('error.unauth'),
                'errors' => ['object' => [__('error.unauth')]]
            ], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ], __('validation'), __('user'));


        $user = User::whereId($id)
            ->firstOrFail();

        $user->update($request->all());

        return (new UserResource($user));
    }


    /**
     * Change the password
     * For Everyone
     *
     * @param UserRequest $request
     * @param $id
     * @return JsonResponse|UserResource
     */
    public function changePassword(Request $request, $id): JsonResponse|UserResource
    {
        $this->id = auth()->id();
        $this->prev_password = User::find($id)->password;
        $this->role = auth()->user()->role;

        if ($this->id != $id && $this->role == 'ordinary') {
            return response()->json([
                'message' => __('error.unauth'),
                'errors' => ['object' => [__('error.unauth')]]
            ], 404);
        }

        $request->validate([
            'previous_password' => 'required|string',
        ], __('validation'), __('user'));

        if (!Hash::check($request->previous_password, $this->prev_password)) {
            return response()->json([
                'message' => __('error.not_match'),
                'errors' => ['object' => [__('error.not_match')]]
            ], 422);
        }

        $request->validate([
            'password' => 'required|string|min:5',
        ], __('validation'), __('user'));

        $user = User::whereId($id)
            ->firstOrFail();

        $item['password'] = $request->password;
        $user->update($item);

        return (new UserResource($user));
    }


    /**
     * Change the role to moderator
     * Only for moderators
     *
     * @param UserRequest $request
     * @param $id
     * @return UserResource|JsonResponse
     */
    public function changeRole(Request $request, $id): UserResource|JsonResponse
    {
        $this->id = auth()->id();

        $request->validate([
            'role' => 'required|in:ordinary,moderator',
        ], __('validation'), __('user'));

        $check = User::whereId($id)->where('role', '=', 'moderator')->get();
        if ($this->id == $id || count($check)) {
            return response()->json([
                'message' => __('error.incorrect_data'),
                'errors' => ['object' => [__('error.incorrect_data')]]
            ], 404);
        }

        $user = User::whereId($id)
            ->firstOrFail();

        $item['role'] = $request->role;
        $user->update($item);

        return (new UserResource($user));
    }

}
