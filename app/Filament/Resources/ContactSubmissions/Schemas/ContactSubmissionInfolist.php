<?php

namespace App\Filament\Resources\ContactSubmissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContactSubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('email')
                    ->label('Email address')
                    ->copyable(),
                TextEntry::make('phone')
                    ->placeholder('-')
                    ->copyable(),
                TextEntry::make('message')
                    ->columnSpanFull(),
                TextEntry::make('ip_address')
                    ->label('IP address')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
