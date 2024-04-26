<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Dipa extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'status',
        'revision',
        'total',
        'work_unit_id'
    ];

    public function bi()
    {
        return $this->hasMany(BudgetImplementation::class, 'dipa_id')->with(['activity', 'accountCode', 'details']);
    }

    public function scopeAccessibility($query, $approval = false, $findId = false, $throw = false)
    {

        $query->select('dipas.*');

        if (Auth::user()->hasRole('SUPER ADMIN PERENCANAAN')) {
        } else
        if (Auth::user()->hasRole('KEPALA UNIT KERJA')) {
            if ($approval) {
                $query =    $query->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-kp', 'reject-kp'])
                        ->where('work_unit_id',  Auth::user()->employee->work_unit_id);
                });
            }
            $query = $query
                ->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-kp', 'reject-kp', 'wait-ppk', 'reject-ppk', 'wait-perencanaan', 'reject-perencanaan', 'wait-spi', 'reject-spi', 'accept'])
                        ->where('work_unit_id',  Auth::user()->employee->work_unit_id);
                })->orWhere('user_id', Auth::user()->id);
        } else
        if (Auth::user()->hasRole('PPK')) {
            if ($approval) {
                $query =    $query->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-ppk', 'reject-ppk'])
                        // ->where('ppk_id',  Auth::user()->id)
                    ;
                });
            }
            $query = $query
                ->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-perencanaan', 'reject-perencanaan', 'wait-spi', 'reject-spi', 'wait-ppk', 'reject-ppk', 'accept'])
                        // ->where('ppk_id',  Auth::user()->id)
                    ;
                })->orWhere('user_id', Auth::user()->id);
        } else
        if (Auth::user()->hasRole('SPI')) {
            if ($approval) {
                $query = $query->where('dipas.status', '=', 'wait-spi');
            }
            $query = $query
                ->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-perencanaan', 'reject-perencanaan', 'wait-spi', 'reject-spi', 'wait-ppk', 'reject-ppk', 'accept']);
                })->orWhere('user_id', Auth::user()->id);
        } else
        if (Auth::user()->hasRole('STAF PPK')) {
            if ($approval) {
                $query = $query->where('dipas.status', '=', 'wait-verificator');
            }
            $query = $query
                ->join('users as u', 'u.id', 'dipas.ppk_id')
                ->leftJoin('employees as p', 'p.user_id', 'u.id')
                ->leftJoin('employees as pp', 'p.head_id', 'pp.id')
                ->leftJoin('users as ss', 'pp.user_id', 'ss.id')
                ->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-spi', 'reject-spi', 'wait-treasurer', 'reject-treasurer', 'wait-verificator', 'reject-verificator', 'wait-ppk', 'reject-ppk', 'accept'])
                        ->where('ss.id',  Auth::user()->id);
                })->orWhere('user_id', Auth::user()->id);
        } else
        if (Auth::user()->hasRole('BENDAHARA')) {
            if ($approval) {
                $query = $query->where('dipas.status', '=', 'wait-treasurer');
            }
            $query = $query
                ->where(function ($query) {
                    $query->where('treasurer_id', Auth::user()->id)
                        ->whereIn('dipas.status', ['wait-treasurer', 'reject-treasurer', 'accept']);
                })->orWhere('user_id', Auth::user()->id);
        } else {
            if ($approval) {
                $query = $query->whereIn('dipas.status', ['reject-verificator', 'reject-spi', 'reject-ppk', 'reject-treasurer', 'draft']);
            }
            $query = $query->where('user_id',  Auth::user()->id);
        }

        if ($findId) {
            $query = $query->where('dipas.id', $findId);
            if ($throw) {
                if (empty($query->first()))
                    throw new \Exception('Data tidak ditemukan atau bukan hak anda lagi!!');
            }
        }

        // dd($query()->get());
        return $query;
    }
}
