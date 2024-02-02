<?php

use App\Models\SettingsApi;

if(!function_exists('settings')){
    function settings(string $type, string|int $key): string|int {

        switch ($type) {
            case 'api':
                $settingsModel = SettingsApi::where('_key', $key)->first();
                break;
            case 'web':
                $settingsModel = SettingsApi::where('_key', $key)->first(); //ileride web için ayrı bir model oluşturulabilir
                break;
            default:
                $settingsModel = null;
                break;
        }

        if(!$settingsModel) return ''; // eğer settings bulunamazsa boş değer döndürür (geliştirmede hata yapısı kurgulanabilir)

        $settingsModel = $settingsModel::where('_key', $key)->first()->_value;

        return is_numeric($settingsModel) ? (int)$settingsModel : $settingsModel; // eğer değer sayısal ise int olarak döndürür

    }

}
