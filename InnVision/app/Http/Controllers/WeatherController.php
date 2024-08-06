<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Branch;


class WeatherController extends Controller
{
    public function showWeather($branchId)
    {
        $branch = Branch::findOrFail($branchId);
        $city = $branch->address;

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'open-weather13.p.rapidapi.com',
            'x-rapidapi-key' => env('RAPIDAPI_KEY'),
        ])->get("https://open-weather13.p.rapidapi.com/city/{$city}/EN");

        $weather = $response->json();

        return view('customer.weather', compact('branch', 'weather'));
}
}
