<?php
namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use App\Jobs\SendInvoiceEmail;
use Carbon\Carbon;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_number')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),
                Forms\Components\Select::make('products')
                    ->label('Products')
                    ->multiple()
                    ->relationship('products', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'shipped' => 'Shipped',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
                Forms\Components\Select::make('schedule_interval')
                    ->label('Schedule Interval')
                    ->options([
                        'none' => 'None',
                        'no_repeat' => 'No Repeat',
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                    ])
                    ->default('none')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('date_of_month', null);
                        $set('time', null);
                        $set('start_day', null);
                    }),
                Forms\Components\DatePicker::make('start_day')
                    ->label('Start Day')
                    ->nullable()
                    ->required()
                    ->visible(fn ($get) => in_array($get('schedule_interval'), ['no_repeat', 'weekly', 'daily', 'monthly'])),
                Forms\Components\TextInput::make('date_of_month')
                    ->label('Date of Month')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(31)
                    ->nullable()
                    ->visible(fn ($get) => $get('schedule_interval') === 'monthly')
                    ->rule(['integer', 'between:1,31'])
                    ->helperText('Emails will be sent on the last valid day if the selected day does not exist in the month.'),
                Forms\Components\TimePicker::make('time')
                    ->label('Time')
                    ->nullable()
                    ->visible(fn ($get) => in_array($get('schedule_interval'), ['daily', 'weekly', 'monthly', 'no_repeat'])),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')->sortable(),
                Tables\Columns\TextColumn::make('customer.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->badge()->colors([
                    'pending' => 'warning',
                    'approved' => 'success',
                    'shipped' => 'info',
                    'cancelled' => 'danger',
                ])->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Order Price')
                    ->getStateUsing(fn ($record) => $record->products->sum(fn ($product) => $product->price * $product->pivot->quantity))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('schedule_interval')->label('Schedule')->sortable(),
                Tables\Columns\TextColumn::make('start_day')->label('Schedule Start')->date()->sortable(),
                Tables\Columns\TextColumn::make('date_of_month')
                    ->label('Date of Month')
                    ->sortable()
                    ->getStateUsing(fn ($record) => Carbon::createFromDate(null, null, $record->date_of_month)->endOfMonth()->day < $record->date_of_month ? Carbon::createFromDate(null, null, $record->date_of_month)->endOfMonth()->day : $record->date_of_month),
                Tables\Columns\TextColumn::make('time')->label('Scheduled Time')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('sendInvoice')
                    ->label('Send Invoice')
                    ->icon('heroicon-o-rectangle-stack')
                    ->action(fn (Order $record) => dispatch(new SendInvoiceEmail($record->id)))
                    ->requiresConfirmation()
                    ->successNotificationTitle('Invoice email sent successfully!')
                    ->visible(fn (Order $record) => $record->status !== 'cancelled'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductRelationManager::class,
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
