<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class Dipa extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'status',
        'revision',
        'total',
        'work_unit_id',
        'head_id',
        'user_id',
        'timeline_id'
    ];

    public function activity()
    {
        return $this->hasMany(Activity::class, 'dipa_id');
    }

    public function bi()
    {
        return $this->hasMany(BudgetImplementation::class, 'dipa_id')->with(['activity', 'accountCode', 'details']);
    }

    public function unit()
    {
        return $this->belongsTo(WorkUnit::class, 'work_unit_id', 'id')->with('unitBudgets');
    }

    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->with('unit')->where('work_unit_id', Auth::user()->employee->work_unit_id)->latest('revision')->first();
    }

    public function scopeCopyActivity($query, $newId, $newCode, $newName, $oldId)
    {
        $old = Activity::with(['withdrawalPlans', 'activityRecap'])->where('dipa_id', '=', $oldId)->where('code', '=', $newCode)->where('name', '=', $newName)->first();
        if (!empty($old)) {
            $newWd = [];
            foreach ($old->withdrawalPlans as $wd) {
                $newWd[] = [
                    'activity_id' => $newId,
                    'month' => $wd->month,
                    'amount_withdrawn' => $wd->amount_withdrawn,
                    'notes' => $wd->notes,
                ];
            }
            WithdrawalPlan::insert($newWd);

            if ($old->activityRecap) {
                ActivityRecap::create([
                    'activity_id' => $newId,
                    'attachment_path' => $old->activityRecap->attachment_path,
                    'description' => $old->activityRecap->description,
                ]);
            }
        }
        // return $query->with('unit')->where('work_unit_id', Auth::user()->employee->work_unit_id)->latest('revision')->first();
    }

    public function scopeAccessibility($query, $approval = false, $findId = false, $throw = false)
    {

        $query->select('dipas.*');

        if (Auth::user()->hasRole('SUPER ADMIN PERENCANAAN')) {
            if ($approval) {
                // dd('syto');
                $query =    $query->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-perencanaan', 'reject-perencanaan'])
                        // ->where('work_unit_id',  Auth::user()->employee->work_unit_id)
                    ;
                });
            } else {
                $query = $query
                    ->where(function ($query) {
                        $query->whereIn('dipas.status', ['wait-kp', 'reject-kp', 'wait-ppk', 'reject-ppk', 'wait-perencanaan', 'reject-perencanaan', 'wait-spi', 'reject-spi', 'accept', 'release'])
                            // ->where('work_unit_id',  Auth::user()->employee->work_unit_id)
                        ;
                    })->orWhere('user_id', Auth::user()->id);
            }
        } else
        if (Auth::user()->hasRole('KPA (REKTOR)')) {
            if ($approval) {
                $query =    $query->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-kpa', 'reject-kpa'])
                        // ->where('work_unit_id',  Auth::user()->employee->work_unit_id)
                    ;
                });
            } else {
                $query = $query
                    ->where(function ($query) {
                        $query->whereIn('dipas.status', ['wait-kpa', 'reject-kpa', 'wait-kp', 'reject-kp', 'wait-ppk', 'reject-ppk', 'wait-perencanaan', 'reject-perencanaan', 'wait-spi', 'reject-spi', 'accept', 'release'])
                            // ->where('work_unit_id',  Auth::user()->employee->work_unit_id)
                        ;
                    })->orWhere('user_id', Auth::user()->id);
            }
        } else
        if (Auth::user()->hasRole('KEPALA UNIT KERJA')) {
            if ($approval) {
                $query =    $query->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-kp', 'reject-kp'])
                        ->where('work_unit_id',  Auth::user()->employee->work_unit_id);
                });
            } else {

                $query = $query
                    ->where(function ($query) {
                        $query->whereIn('dipas.status', ['wait-kpa', 'reject-kpa', 'wait-kp', 'reject-kp', 'wait-ppk', 'reject-ppk', 'wait-perencanaan', 'reject-perencanaan', 'wait-spi', 'reject-spi', 'accept', 'release'])
                            ->where('work_unit_id',  Auth::user()->employee->work_unit_id);
                    })->orWhere('user_id', Auth::user()->id);
            }
        } else
        if (Auth::user()->hasRole('PPK')) {
            if ($approval) {
                $query =    $query->where(function ($query) {
                    $query->whereIn('dipas.status', ['wait-ppk', 'reject-ppk'])
                        // ->where('ppk_id',  Auth::user()->id)
                    ;
                });
            } else {


                $query = $query
                    ->leftJoin('timelines as t', 't.id', 'dipas.timeline_id')
                    ->where(function ($query) {
                        $query->whereIn('dipas.status', ['wait-perencanaan', 'reject-perencanaan', 'wait-spi', 'reject-spi', 'wait-ppk', 'reject-ppk', 'accept', 'release'])
                            ->where('t.metode', 'ppk');
                    })->orWhere('dipas.user_id', Auth::user()->id);
            }
        } else
        if (Auth::user()->hasRole('SPI')) {
            // if (Auth::user()->hasRole('KEPALA SPI')) {
            if ($approval) {
                $query = $query->where('dipas.status', '=', 'wait-spi');
            } else {

                $query = $query
                    ->where(function ($query) {
                        $query->whereIn('dipas.status', ['wait-perencanaan', 'reject-perencanaan', 'wait-spi', 'reject-spi', 'wait-ppk', 'reject-ppk', 'accept', 'release']);
                    })->orWhere('user_id', Auth::user()->id);
            }
        } else
        if (Auth::user()->hasRole('STAF PPK')) {
            if ($approval) {
                $query = $query->where('dipas.status', '=', 'wait-verificator');
            } else {

                $query = $query
                    ->join('users as u', 'u.id', 'dipas.ppk_id')
                    ->leftJoin('employees as p', 'p.user_id', 'u.id')
                    ->leftJoin('employees as pp', 'p.head_id', 'pp.id')
                    ->leftJoin('users as ss', 'pp.user_id', 'ss.id')
                    ->where(function ($query) {
                        $query->whereIn('dipas.status', ['wait-spi', 'reject-spi', 'wait-treasurer', 'reject-treasurer', 'wait-verificator', 'reject-verificator', 'wait-ppk', 'reject-ppk', 'accept'])
                            ->where('ss.id',  Auth::user()->id);
                    })->orWhere('user_id', Auth::user()->id);
            }
        } else
        if (Auth::user()->hasRole('BENDAHARA')) {
            if ($approval) {
                $query = $query->where('dipas.status', '=', 'wait-treasurer');
            } else {

                $query = $query
                    ->where(function ($query) {
                        $query->where('treasurer_id', Auth::user()->id)
                            ->whereIn('dipas.status', ['wait-treasurer', 'reject-treasurer', 'accept']);
                    })->orWhere('user_id', Auth::user()->id);
            }
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
