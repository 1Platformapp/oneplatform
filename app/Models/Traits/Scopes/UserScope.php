<?php

namespace App\Models\Traits\Scopes;

trait UserScope
{
    public function scopeFilters($query, array $data = [])
    {
        $query->when(!empty($data['search']), function ($q) use ($data) {
            $q->where('name', 'LIKE', '%' . $data['search'] . '%');
        });

        return $query;
    }
}