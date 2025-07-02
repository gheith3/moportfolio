<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Filament\Resources\ProfileResource\RelationManagers;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Profile';

    protected static ?string $modelLabel = 'Profile';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('title')
                            ->label('Professional Title')
                            ->placeholder('e.g., Full-Stack Developer')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Tagline')
                            ->placeholder('e.g., Crafting Digital Solutions')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('greeting')
                            ->required()
                            ->default('Hello, I am')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('About')
                    ->schema([
                        Forms\Components\Textarea::make('bio')
                            ->label('Biography')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Media & Files')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Profile Image')
                            ->image()
                            ->directory('profiles')
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400'),

                        Forms\Components\FileUpload::make('background_image')
                            ->label('Hero Background Image')
                            ->image()
                            ->directory('backgrounds')
                            ->imageEditor(),

                        Forms\Components\FileUpload::make('cv_file')
                            ->label('CV/Resume File')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('documents'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Dynamic Content')
                    ->schema([
                        Forms\Components\Repeater::make('animated_texts')
                            ->label('Animated Text Items')
                            ->simple(
                                Forms\Components\TextInput::make('text')
                                    ->required()
                                    ->placeholder('e.g., Laravel Developer')
                            )
                            ->defaultItems(3)
                            ->addActionLabel('Add Text Item')
                            ->collapsible(),

                        Forms\Components\Repeater::make('social_links')
                            ->label('Social Media Links')
                            ->schema([
                                Forms\Components\TextInput::make('platform')
                                    ->required()
                                    ->placeholder('e.g., Facebook'),

                                Forms\Components\TextInput::make('url')
                                    ->required()
                                    ->url()
                                    ->placeholder('https://facebook.com/yourprofile'),

                                Forms\Components\TextInput::make('icon')
                                    ->required()
                                    ->placeholder('e.g., fab fa-facebook-f')
                                    ->helperText('FontAwesome icon class'),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->addActionLabel('Add Social Link')
                            ->collapsible(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->size(50),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\SkillsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'view' => Pages\ViewProfile::route('/{record}'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
