<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Setting Information')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->required()
                            ->maxLength(255)
                            ->unique(Setting::class, 'key', ignoreRecord: true)
                            ->helperText('Unique identifier for this setting'),

                        Forms\Components\Select::make('group')
                            ->options([
                                'general' => 'General',
                                'contact' => 'Contact',
                                'social' => 'Social Media',
                                'seo' => 'SEO',
                                'analytics' => 'Analytics',
                                'email' => 'Email',
                                'appearance' => 'Appearance',
                            ])
                            ->searchable()
                            ->preload()
                            ->default('general'),

                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Long Text',
                                'number' => 'Number',
                                'boolean' => 'True/False',
                                'url' => 'URL',
                                'email' => 'Email',
                                'json' => 'JSON',
                                'file' => 'File',
                            ])
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(fn(Forms\Set $set) => $set('value', null)),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Value')
                    ->schema([
                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->visible(fn(Forms\Get $get) => in_array($get('type'), ['text', 'number', 'url', 'email']))
                            ->type(fn(Forms\Get $get) => match ($get('type')) {
                                'number' => 'number',
                                'url' => 'url',
                                'email' => 'email',
                                default => 'text'
                            }),

                        Forms\Components\Textarea::make('value')
                            ->rows(4)
                            ->visible(fn(Forms\Get $get) => $get('type') === 'textarea'),

                        Forms\Components\Toggle::make('value')
                            ->visible(fn(Forms\Get $get) => $get('type') === 'boolean'),

                        Forms\Components\Textarea::make('value')
                            ->label('JSON Value')
                            ->rows(6)
                            ->visible(fn(Forms\Get $get) => $get('type') === 'json')
                            ->helperText('Enter valid JSON'),

                        Forms\Components\FileUpload::make('value')
                            ->visible(fn(Forms\Get $get) => $get('type') === 'file')
                            ->directory('settings'),

                        Forms\Components\Textarea::make('description')
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('Describe what this setting does...'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable(),

                Tables\Columns\TextColumn::make('group')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'general' => 'gray',
                        'contact' => 'info',
                        'social' => 'success',
                        'seo' => 'warning',
                        'analytics' => 'danger',
                        'email' => 'primary',
                        'appearance' => 'secondary',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('type')
                    ->badge(),

                Tables\Columns\TextColumn::make('value')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    })
                    ->formatStateUsing(function ($state, $record) {
                        return match ($record->type) {
                            'boolean' => $state ? 'True' : 'False',
                            'file' => $state ? 'File uploaded' : 'No file',
                            'json' => 'JSON data',
                            default => $state
                        };
                    }),

                Tables\Columns\TextColumn::make('description')
                    ->limit(40)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'contact' => 'Contact',
                        'social' => 'Social Media',
                        'seo' => 'SEO',
                        'analytics' => 'Analytics',
                        'email' => 'Email',
                        'appearance' => 'Appearance',
                    ]),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Long Text',
                        'number' => 'Number',
                        'boolean' => 'True/False',
                        'url' => 'URL',
                        'email' => 'Email',
                        'json' => 'JSON',
                        'file' => 'File',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('group');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'view' => Pages\ViewSetting::route('/{record}'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
