<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Parental\HasParent;

class CompanyUser extends User implements MustVerifyEmail
{
    use HasFactory;
    use HasParent;
    use BelongsToCompany;

    protected $with = ['company'];

    /**
     * Get the company that the user belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(
            function ($user) {
                if (!$user->password) {
                    // $user->password = Hash::make(Str::random(16));
                    $user->password = Hash::make('password');
                }
            }
        );

        static::created(
            function ($user) {
                $user->assignRole('company-user');
            }
        );
    }

    public function setCompany(int $id)
    {
        $this->company_id = $id;
        return $this;
    }
}
