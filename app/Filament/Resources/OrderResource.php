<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\CategoryOrTag;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table as ModelsTable;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $menu = Menu::get();

        $items = [];
        foreach ($menu as $item) {
            $items[$item->id] = $item->name ?? 'asdf';
        }

        return $form
            ->schema([
                Section::make()
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

                        TextInput::make('discount_amount'),


                    ])->columns(2),
                Section::make('Starters')
                    ->schema([
                        Repeater::make('starters')->schema(
                            [
                                Select::make('menu_id')
                                    ->options($items),
                                TextInput::make('quantity')
                            ]
                        )->columns(2)
                            ->relationship(
                                'starters',
                            )
                            ->label(''),

                    ]),
                Section::make('Main courses')
                    ->schema([
                        Repeater::make('main_courses')->schema(
                            [
                                Select::make('menu_id')
                                    ->options($items),
                                TextInput::make('quantity')
                            ]
                        )
                            ->columns(2)
                            ->relationship(
                                'main_course',
                            )
                            // ->mutateRelationshipDataBeforeCreateUsing(function ($data) {
                            //     $data['order_section'] = 'main_course';
                            //     return $data;
                            // })
                            ->label(''),
                    ]),


                Section::make('Dissert')
                    ->schema([
                        Repeater::make('disserts')->schema(
                            [
                                Select::make('menu_id')
                                    ->options($items),
                                TextInput::make('quantity')
                            ]
                        )
                            ->columns(2)
                            ->relationship(
                                'dissert',
                            )
                            ->mutateRelationshipDataBeforeCreateUsing(function ($data) {
                                $data['order_section'] = 'dissert';
                                return $data;
                            })
                            ->label(''),
                    ]),

                Section::make('Package')
                    ->schema([
                        Repeater::make('packages')->schema(
                            [
                                Select::make('menu_id')
                                    ->options($items),
                                TextInput::make('quantity')
                            ]
                        )
                            ->columns(2)
                            ->relationship(
                                'package',
                            )
                            ->mutateRelationshipDataBeforeCreateUsing(function ($data) {
                                $data['order_section'] = 'package';
                                return $data;
                            })
                            ->label(''),
                    ]),


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
