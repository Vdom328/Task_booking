<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $data = getData();
        $meals = array_reduce($data['dishes'], function ($carry, $dish) {
            return array_merge($carry, $dish['availableMeals']);
        }, []);

        $meals = array_values(array_unique($meals));

        return view('home', compact('meals'));
    }

    public function getRestaurant(Request $request)
    {
        $meal = $request->input('meal');

        if ($request->input('number_people') < 1 || $request->input('number_people') > 10) {
            return response()->json('error');
        }
        $query = getData();

        $data = collect($query['dishes'])
            ->filter(function ($dish) use ($meal) {
                return in_array($meal, $dish['availableMeals']);
            })
            ->unique('restaurant')
            ->pluck('restaurant')
            ->values();
        $option = view('partials.option', compact('data'))->render();
        return response()->json($option);
    }

    public function getDish(Request $request)
    {
        $meal = $request->input('meal');
        $restaurant = $request->input('restaurant');

        if ($request->input('restaurant') == '') {
            return response()->json('error');
        }

        $query = getData();
        $data = collect($query['dishes'])
            ->filter(function ($dish) use ($meal, $restaurant) {
                return in_array($meal, $dish['availableMeals']) && $dish['restaurant'] === $restaurant;
            });

        if ($request->input('addDish') == true) {
            $html = view('partials.form-dish', compact('data'))->render();
            return response()->json($html);
        }

        $option = view('partials.option-dish', compact('data'))->render();
        return response()->json($option);
    }


}
