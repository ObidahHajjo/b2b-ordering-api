<?php

namespace App\Services;

use App\Models\ContactMessage;

class ContactService
{
    /**
     * Store a contact message.
     *
     * @param  array<string, mixed>  $attributes  Contact message attributes.
     * @return ContactMessage Created contact message.
     */
    public function create(array $attributes): ContactMessage
    {
        return ContactMessage::create($attributes);
    }
}
