<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Customer;

class CustomerTableWidget extends TableWidget
{
    protected static ?string $heading = 'Customers List';

    public function table(Table $table): Table
    {
        return $table
            ->query(Customer::query())
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->date()->sortable(),
            ]);
    }
}
