<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth:api', ['only' => ['store', 'update', 'destroy', 'index']]);
    }

    public function index(){
        $products = Product::with('variations')->with('createdBy')->get();
        return response()->json($products);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'slug'              => 'required|unique:products,slug',
            'name'              => 'required',
            'variations'        => $request->hasVariation == "true" ? 'required|array' : [],
            'initial_inventary' => $request->hasVariation == "true" ? [] : 'required|numeric',
            'price'             => $request->hasVariation == "true" ? [] : 'required|numeric',
            'actual_inventary'  => $request->hasVariation == "true" ? [] : 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        
        if ($request->hasVariation == "true") {
            foreach ($request->variations as $variation) {
                if (!is_array($variation)) {
                    return response()->json(['message' => 'variarion needs to be an array'], 401);
                }

                $validatorVariations = Validator::make($variation, [
                'name' => 'required',
                'type' => 'required',
                'initial_inventary' => 'required|numeric',
                'price' => 'required|numeric',
                'actual_inventary' => 'required|numeric',
            ]);
           
                if ($validatorVariations->fails()) {
                    return response()->json($validatorVariations->errors());
                }
            }
        }

        $product = new Product;

        $product->slug = $request->slug;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->created_by = auth()->user()->id;

        $product->save();
        if ($request->hasVariation == "true") {

            foreach($request->variations as $variation){
                $product->variations()->create([
                    'name' => $variation['name'],
                    'type' => $variation['type'],
                    'initial_inventary' => $variation['initial_inventary'],
                    'actual_inventary' => $variation['actual_inventary'],
                    'price' => $variation['price'],
                    'created_by' => auth()->user()->id,
                ]);
            }
        }else{
            $product->variations()->create([
                'name' => 'default',
                'initial_inventary' => $request->initial_inventary,
                'actual_inventary' => $request->actual_inventary,
                'price' => $request->price,
                'created_by' => auth()->user()->id,
            ]);
        }

        $product->load('variations');
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if($product == null){
            return response()->json(['message' => 'not found'], 404);
        }

        $product->load('variations');
        return response()->json($product, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'slug'       => ['required', Rule::unique('products')->ignore($id)],
            'name'       => 'required',
            'variations'        => $request->hasVariation == "true" ? 'required|array' : [],
            'initial_inventary' => $request->hasVariation == "true" ? [] : 'required|numeric',
            'price'             => $request->hasVariation == "true" ? [] : 'required|numeric',
            'actual_inventary'  => $request->hasVariation == "true" ? [] : 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        
        if ($request->hasVariation == "true") {
            foreach($request->variations as $variation){
            
                if(!is_array($variation)){
                    return response()->json(['message' => 'variarion needs to be an array'], 401);
                }
                
                $validatorVariations = Validator::make($variation, [
                    'name' => 'required',
                    'type' => 'required',
                    'initial_inventary' => 'required|numeric',
                    'price' => 'required|numeric',
                    'actual_inventary' => 'required|numeric',
                ]);
            
                if ($validatorVariations->fails()) {
                    return response()->json($validatorVariations->errors());
                }
            
            }
        }

        $product = Product::find($id);

        $product->slug = $request->slug;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->created_by = auth()->user()->id;

        $product->save();
        $product->variations()->delete();
        if ($request->hasVariation == "true") {
            foreach($request->variations as $variation){
                $product->variations()->create([
                    'name' => $variation['name'],
                    'type' => $variation['type'],
                    'initial_inventary' => $variation['initial_inventary'],
                    'actual_inventary' => $variation['actual_inventary'],
                    'price' => $variation['price'],
                    'created_by' => auth()->user()->id,
                ]);
            }
        }else{
            $product->variations()->create([
                'name' => 'default',
                'initial_inventary' => $request->initial_inventary,
                'actual_inventary' => $request->actual_inventary,
                'price' => $request->price,
                'created_by' => auth()->user()->id,
            ]);
        }
        $product->load('variations');
        return response()->json($product, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id)->delete();
        return response()->json($product, 201);
    }
}
