<?php

namespace App\Models\Traits\Scopes;

trait UserScope
{
    public function scopeFilters($query, array $data = [])
    {
        $query->when(!empty($data['search']), function ($q) use ($data) {
            $q->where('name', 'LIKE', '%' . $data['search'] . '%');
        });

        $query->when(!empty($data['agent_id']), function ($q) use ($data) {
            $q->whereHas('contacts', function ($q) use ($data) {
                $q->where('agent_id', $data['agent_id']);
            });
        });

        $query->when(!empty($data['contact_id']), function ($q) use ($data) {
            $q->whereHas('contacts', function ($q) use ($data) {
                $q->where('contact_id', $data['contact_id']);
            });
        });


        return $query;
    }
}