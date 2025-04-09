<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Interfaces\CountryServiceInterface;
use Illuminate\Support\Facades\Storage;

class RestCountriesService implements CountryServiceInterface
{
    public function getCountries(): array
    {
        try {
            $response = Http::timeout(5)->get('https://restcountries.com/v3.1/all?fields=name,idd');

            if ($response->successful()) {
                $countries = $response->json();
            } else {
                throw new \Exception('API did not respond with success');
            }
        } catch (\Exception $e) {
            $json = file_get_contents(database_path('data/countries.json'));
            $countries = json_decode($json, true);
        }

        return collect($countries)
            ->filter(function ($country) {
                return isset($country['idd']['root']) && isset($country['idd']['suffixes'][0]);
            })
            ->mapWithKeys(function ($country) {
                $root = $country['idd']['root'] ?? '';
                $suffix = $country['idd']['suffixes'][0] ?? '';
                $code = ltrim($root . $suffix, '+');
                $name = $country['name']['common'] ?? 'Unknown';

                return [$code => [
                    'name' => "{$name}",
                    'code' => $code,
                ]];
            })
            ->sortBy('name')
            ->toArray();
    }
}
