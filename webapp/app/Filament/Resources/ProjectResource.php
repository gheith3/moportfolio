<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationLabel = 'Projects';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $context, $state, Forms\Set $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Project::class, 'slug', ignoreRecord: true),

                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('client')
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('completion_date')
                            ->native(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Featured Image')
                            ->image()
                            ->required()
                            ->directory('projects')
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('600'),

                        Forms\Components\FileUpload::make('gallery_images')
                            ->label('Gallery Images')
                            ->image()
                            ->multiple()
                            ->directory('projects/gallery')
                            ->imageEditor()
                            ->reorderable()
                            ->maxFiles(10),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Links')
                    ->schema([
                        Forms\Components\TextInput::make('project_url')
                            ->label('Live Project URL')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('github_url')
                            ->label('GitHub Repository')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Technical Details')
                    ->schema([
                        Forms\Components\Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description'),
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'portfolio' => 'Portfolio',
                                        'blog' => 'Blog',
                                    ])
                                    ->default('portfolio')
                                    ->required(),
                            ]),

                        Forms\Components\TagsInput::make('technologies')
                            ->placeholder('Add technology (press Enter)')
                            ->helperText('Enter technologies used in this project'),
                    ]),

                Forms\Components\Section::make('Display Settings')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Higher numbers appear first'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Project')
                            ->default(false)
                            ->helperText('Show in featured projects section'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Show this project on the website'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->size(60)
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('categories.name')
                    ->badge()
                    ->separator(','),

                Tables\Columns\TextColumn::make('client')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('completion_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured')
                    ->native(false),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only')
                    ->native(false),

                Tables\Filters\SelectFilter::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload(),
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
            ->defaultSort('sort_order', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
