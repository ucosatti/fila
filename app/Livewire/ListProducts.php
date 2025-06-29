<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ListProducts extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;


    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
            ])
            ->recordActions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->action(fn (User $record) => $record->delete()),

                Action::make('edit')
                    ->schema([
                        TextInput::make('name')
                    ->afterStateUpdatedJs(<<<'JS'
                        $set('email',  $state);
                    JS
                    ),
                        TextInput::make('email'),

                    ])
                    ->slideOver()
            ]);
    }

    public function render(): View
    {
        return view('livewire.list-products')->layout('components.layouts.app');
    }
}
