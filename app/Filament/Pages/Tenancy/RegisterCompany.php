<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Company;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;

class RegisterCompany extends RegisterTenant
{
  public static function getLabel(): string
  {
    return 'Register Company';
  }

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name'),
        TextInput::make('slug'),
        // ...
      ]);
  }

  protected function handleRegistration(array $data): Company
  {
    $company = Company::create($data);

    $company->members()->attach(auth()->user());

    return $company;
  }
}