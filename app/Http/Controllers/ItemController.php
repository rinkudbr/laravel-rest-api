<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Property;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = JWTAuth::user()->id;
        return Item::with('properties')->where('user_id', $user_id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'price');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'price' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new item
        $item = $this->user->items()->create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        //Item created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Item created successfully',
            'data' => $item
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::with('properties')->where('id', $id)->get();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Item not found.'
            ], 400);
        }

        return $item;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //Validate data
        $data = $request->only('name', 'price');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'price' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, update item
        $item = $item->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        //item updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully',
            'data' => $item
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully'
        ], Response::HTTP_OK);
    }
}
