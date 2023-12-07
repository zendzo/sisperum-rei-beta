<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('province_id')
                    ->relationship(name: 'province', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->afterStateUpdated(function (Set $set){
                      $set('regency_id', null);
                      $set('district_id', null);
                    })
                    ->live()
                    ->required(),
                Forms\Components\Select::make('regency_id')
                    ->options(
                          fn (Get $get): Collection => Regency::query()
                            ->where('province_id', $get('province_id'))
                            ->pluck('name', 'id')
                        )
                    ->afterStateUpdated(fn (Set $set) => $set('district_id', null))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
                Forms\Components\Select::make('district_id')
                  ->options(
                    fn (Get $get): Collection => District::query()
                      ->where('regency_id', $get('regency_id'))
                      ->pluck('name', 'id')
                  )
                  ->afterStateUpdated(fn (Set $set) => $set('village_id', null))
                  ->searchable()
                  ->preload()
                  ->live()
                  ->required(),
                Forms\Components\Select::make('village_id')
                  ->options(
                    fn (Get $get): Collection => Village::query()
                      ->where('district_id', $get('district_id'))
                      ->pluck('name', 'id')
                  )
                  ->searchable()
                  ->preload()
                  ->live()
                  ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('id_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pob')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dob')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('province_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('regency_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('district_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('village_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('id_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pob')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
