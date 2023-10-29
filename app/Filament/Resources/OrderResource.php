<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table as ModelsTable;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        // $items = Menu::select('id', 'name')->get()->toArray();
        // logger('items is: ', $items);

        $menu = Menu::get();

        $items = [];
        foreach ($menu as $item) {
            $items[$item->id] = $item->name;
        }

        logger('items: ', $items);


        return $form
            ->schema([
                TextInput::make('order_no'),
                TextInput::make('order_id'),
                TextInput::make('phone'),
                Select::make('table_id')
                    ->relationship('table', titleAttribute: 'name_or_number'),
                Select::make('order_status')
                    ->required()
                    ->default('processing')
                    ->options(['processing' => 'Processing', 'served' => 'Served', 'checkedout' => 'Checked out']),
                // TextInput::make('paid_amount'),
                // TextInput::make('amount'),
                TextInput::make('discount_amount'),
                Section::make('menuOrders')
                    ->schema([
                        Repeater::make('items')->schema(
                            [
                                Select::make('menu_id')->relationship(''),

                            ]
                        )->relationship()

                    ]),

                // Select::make('order_id')
                //     ->relationship('order', titleAttribute: 'order_no')
                //     ->label('Related order'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_no'),
                TextColumn::make('user.name'),
                TextColumn::make('phone'),
                TextColumn::make('table.name_or_number'),
                TextColumn::make('order.order_id'),
                TextColumn::make('status'),
                TextColumn::make('paid_amount'),
                TextColumn::make('amount'),
                TextColumn::make('discount_amount'),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
