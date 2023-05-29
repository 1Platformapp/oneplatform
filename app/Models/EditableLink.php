<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class EditableLink extends Authenticatable

{
        protected $table = 'editable_links';

        public function scopeCategories( $query)
        {
            return $query->where( 'type', true );
        }

        public function scopeLinksForCategory( $query, $cid)
        {
            return $query->where( 'parent', $cid );
        }

        public function addChild( EditableLink $child)
        {
            $child->parent = $this->id;
            $child->save();
        }
    }
