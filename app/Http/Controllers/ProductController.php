<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // mapped to GET method
    public function getProducts()
    {        
        $data = Product::all();
        //return the result
        return response()->json(['data' => $data]);

    }

    //mapped to PUT method
    public function updateProduct(Request $request, $id)
    {
        if(Product::where('id','=',$id)->get()->isEmpty())
        {
            return response()->json(['msg' => 'Invalid product ID']);
        }

        try{
            Product::where('id','=',$id)->update($request->all());
        }

        catch(QueryException $e){
            return response()->json(['msg' => $e]);
        }

        return response()->json(['msg' => 'Product updated successfully']);
    }
    // mapped to POST method
    public function createProduct(Request $request)
    {        
        try {
            Product::create(['id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'currency' => $request->currency]);
        }
        catch(QueryException $e){
            return response()->json(['msg' => 'Something went wrong. Please try again']);
        }

        return response()->json(['msg'=>'Product created successfully']);
    }

    //mapped to DELETE method
    public function deleteProduct($id){
        if(Product::where('id','=',$id)->get()->isEmpty())
        {
            return response()->json(['msg' => 'Invalid product ID']);
        }
        try{
            Product::where('id','=',$id)->delete();
        }
        catch(QueryException $e){
            return response()->json(['msg' => $e]);
        }

        return response()->json(['msg' => 'Product deleted successfully']);
    }
}
