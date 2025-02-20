<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Information')
                        ->schema([
                            TextInput::make('name'),
                            Group::make([
                                TextInput::make('price')
                                    ->type('number'),
                                TextInput::make('stock')
                                    ->type('number'),
                            ])->columns(2),
                            Textarea::make('description')
                        ]),
                    Wizard\Step::make('Parts')
                        ->schema([
                            Repeater::make('parts')
                                ->label('')
                                ->relationship('parts')
                                ->defaultItems(0)
                                ->reorderable(false)
                                ->columns()
                                ->columnSpanFull()
                                ->simple(
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->columnSpanFull()
                                )
                                ->addAction(function (Action $action): Action {
                                    return $action
                                    ->form([
                                        Forms\Components\TextInput::make('name'),
                                        Forms\Components\TextInput::make('code'),
                                        Forms\Components\Textarea::make('description'),
                                    ])
                                    ->modalHeading('Add Part')
                                    ->modalSubmitActionLabel('Save')
                                    ->modalCancelActionLabel('Cancel');
                                })
                                ->afterStateUpdated(function (Repeater $component, ?array $state) {
                                    Notification::make()
                                        ->title('Current State')
                                        ->body(json_encode($state, JSON_PRETTY_PRINT))
                                        ->info()
                                        ->send();
                                    $component->state($state);
                                })
                                ->collapsed()
                                ->collapsible(),
                        ]),
                ])
                ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price'),
                TextColumn::make('parts_count')
                    ->label('Parts')
                    ->state(function (Product $record): string {
                        return $record->parts()->count();
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
