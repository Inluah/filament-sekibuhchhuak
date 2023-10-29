<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('phone'),
                TextInput::make('username')->nullable(),
                TextInput::make('email'),

                Toggle::make('change_password')
                    ->reactive()->columnSpanFull()
                    ->hiddenOn('create'),
                TextInput::make('password')
                    ->hidden(
                        function (callable $get) {
                            return $get('change_password') != true && $get('id');
                        }
                    ),
                TextInput::make('password_confirmation')->hiddenOn('edit'),
            ]);
        // return $form
        //     ->schema([
        //         TextInput::make('name'),
        //         TextInput::make('phone'),
        //         TextInput::make('username'),
        //         TextInput::make('email'),
        //         Toggle::make('change_password'),
        //         TextInput::make('password')
        //         ->reactive(

        //         )
        //             ->hidden(fn (callable $get) => $get('change_password') != true),
        //         // ->hiddenOn('edit'),
        //         TextInput::make('password_confirmation')->hiddenOn('edit'),
        //     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('username'),
                TextColumn::make('phone'),
                TextColumn::make('email'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
