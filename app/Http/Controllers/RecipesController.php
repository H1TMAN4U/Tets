<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredients;
use App\Models\Recipes;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $recipes=Recipes::all()->where('users_id');
        // $ingredients=Ingredients::all();
        // return view('recipes.user-recipes.index',['ingredients'=>$ingredients],compact('recipes'));

        $id=Auth::user()->id;
        // $recipe=Recipe::with('getCategory')->where("users_id",$id)->get();
        $recipes=Recipes::select('id','name', 'img')->where('users_id', $id)->paginate(8);
        return view("recipes.user-recipes.index", compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $recipes=Recipes::all();
        $category=Category::all();
        $ingredients=Ingredients::all();
        return view('recipes.user-recipes.create',['ingredients'=>$ingredients,'category'=>$category, 'recipes'=>$recipes]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file_name = time() . '.' . request()->img->getClientOriginalExtension();
        request()->img->move(public_path('images'), $file_name);
        $users_id= Auth::id();

        $recipes = new Recipes;
        $recipes->name = $request->name;
        $recipes->ingredients = $request->input('ingredients');
        $recipes->descriptions = $request->descriptions;
        $recipes->instructions = $request->instructions;
        $recipes->img = $file_name;
        $recipes -> category_id = $request->category_id;
        $recipes -> users_id = $users_id;
        $recipes->save();
        return redirect()->route('recipes.index');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $RecipeData= Recipes::find($id);
        // $ingredient= Ingredients::orderBy('name', 'asc')->get();
        $category=Recipes::with('getCategory')->get();
        $recipes = DB::table("recipes")->where('id',$id)->get();
        return view("recipes.user-recipes.show",
        ["recipes"=>$recipes,"category"=>$category],
        compact('recipes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipes  $recipes
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipes $recipe)
    {
        $ingredients=Ingredients::all();
        $category=Category::all();
        return view('recipes.user-recipes.edit',
        ['ingredients'=>$ingredients,'category'=>$category],compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipes   $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipes $recipes)
    {
        $request->validate([
            'img'=>'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:
            min_width=100,min_height=100,max_width=5000,max_height=5000'
        ]);
        $img = $request->hidden_img;
        if($request->img != '')
        {
            $img = time() . '.' . request()->img->getClientOriginalExtension();
            request()->img->move(public_path('images'), $img);
        }
        $recipes = Recipes::find($request->hidden_id);
        $recipes->name = $request->name;
        $recipes->ingredients = $request->input('ingredients');
        $recipes->descriptions = $request->descriptions;
        $recipes->instructions = $request->instructions;
        $recipes->img = $img;
        $recipes->save();
        return redirect()->route('recipes.index')->with('success', 'recipe Data has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipes $recipes)
    {
        $recipes->delete();
        return redirect()->route('recipes.index')->with('success', 'Student Data deleted successfully');
    }
    // public function IDrecipes($id)
    // {
    //     $RecipeData= Recipes::find($id);
    //     $ingredient= Ingredients::orderBy('name')->get();
    //     $recipes = Recipes::with('getCategory')->where('id',$id)->get();
    //     return view("recipes.user-recipes.show-full",
    //     ["recipes"=>$recipes,"ingredient"=>$ingredient,"RecipeData"=>$RecipeData],
    //     compact('recipes'));
    // }
    public function guest_recipes(Recipes $recipes)
    {
        $recipes= Recipes::all();
        $category=Recipes::with('getCategory')->get();
        $data = Recipes::latest()->paginate(5);
        return view('recipes.guest-recipes.show',
        ["recipes"=>$recipes,"category"=>$category],
        compact('data'));
    }
    public function IDrecipe($id)
    {
        $RecipeData= Recipes::find($id);
        $ingredients= Ingredients::orderBy('name')->get();
        $recipes = Recipes::with('getCategory')->where('id',$id)->get();
        return view("recipes.show-full",
        ["recipes"=>$recipes,"ingredients"=>$ingredients,"RecipeData"=>$RecipeData],
        compact('recipes'));
        // return dd()
    }

    // public function search()
    // {
    //     $data = Recipes::latest()->paginate(5);
    //     // $category=RecipesController::with('getCategory')->get();
    //     $search_text=$_GET["query"];
    //     $recipes = DB::table("recipes")->where('name','LIKE', '%'.$search_text.'%')->get();
    //     return view('recipes.search',
    //     ["recipes"=>$recipes], compact('data'));
    // }
}
