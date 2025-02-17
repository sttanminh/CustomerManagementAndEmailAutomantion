<?php
namespace App\Filament\Resources;

use App\Filament\Resources\EmailLogResource\Pages;
use App\Models\EmailLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmailLogResource extends Resource
{
    protected static ?string $model = EmailLog::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')->label('Log ID')->sortable(),
            Tables\Columns\TextColumn::make('recipient')->label('Recipient')->searchable(),
            Tables\Columns\TextColumn::make('email_content')->label('Email Content')->limit(50),
            Tables\Columns\TextColumn::make('timestamp')->label('Sent At')->dateTime(),
            Tables\Columns\TextColumn::make('attachment')->label('Attachment')->formatStateUsing(function ($state) {
                if ($state) {
                    $url = asset($state);  // ✅ Generate URL to the file
                    return "<a href='{$url}' target='_blank' class='text-blue-500 underline'>Open PDF</a>";
                }
                return 'No Attachment';
            })->html(), // ✅ Allow HTML rendering
        ])
        ->defaultSort('timestamp', 'desc');
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailLogs::route('/'),
        ];
    }
}
