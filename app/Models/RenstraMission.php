<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenstraMission extends Model
{
    use HasFactory;

    protected $fillable = ['renstra_id', 'description'];

    public function indicatorDipa()
    {
        return $this->hasMany(RenstraIndicator::class);
    }

    public static function getWithDipa($dipa)
    {
        // $res = RenstraMission::with('indicatorDipa.sasaranDipa.indikatorPerkinDipa.activity.bi')
        //     ->whereHas('indicatorDipa', function ($query, $dipa) {
        //         $query->whereHas('sasaranDipa', function ($query, $dipa) {
        //             $query->whereHas('indikatorPerkinDipa', function ($query, $dipa) {
        //                 $query->whereHas('activity', function ($query, $dipa) {
        //                     $query->where('dipa_id', $dipa);
        //                 });
        //             });
        //         });
        //     })
        //     ->get();
        $res = RenstraMission::with('indicatorDipa.sasaranDipa.indikatorPerkinDipa.activityDipa')
            ->whereHas('indicatorDipa.sasaranDipa.indikatorPerkinDipa.activityDipa', function ($query) use ($dipa) {
                $query->where('dipa_id', 1);
            })
            ->get();
        // $res = RenstraMission::with([
        //     'indicatorDipa.sasaranDipa.indikatorPerkinDipa.activityDipa' => function ($query) use ($dipa) {
        //         $query->where('dipa_id', $dipa);
        //     }
        // ])->whereHas('indicatorDipa.sasaranDipa.indikatorPerkinDipa.activityDipa', function ($query) use ($dipa) {
        //     $query->where('dipa_id', $dipa);
        // })->get()->toArray();
        // dd($res);
        // return $res;
        $new = [];
        // foreach ($res as $k_mission => $mission) {
        //     foreach ($mission['indicator_dipa'] as $k_indikator => $indicator_dipa) {
        //         foreach ($indicator_dipa['sasaran_dipa'] as $k_sasaran => $sasaranDipa) {
        //             foreach ($sasaranDipa['indikator_perkin_dipa'] as $k_ind_perkin => $ind_perkin) {
        //                 foreach ($ind_perkin['activity'] as $k_activity => $activity) {
        //                     $rowspan_activity = 0;
        //                     foreach ($activity['bi'] as $k_bi => $bi) {
        //                         dd($bi['details']);
        //                         $rowspan = count($bi['details']);
        //                         $new['account'] = $d[''];

        //                         $rowspan_activity +=  $rowspan + 1;
        //                         // $res[$k_mission]['indicator_dipa'][$k_indikator]['sasaran_dipa'][$k_sasaran]['indikator_perkin_dipa'][$k_ind_perkin]['activity'][$k_activity]['bi'][$k_bi]['account_code']['rowspan'] = $rowspan;
        //                     }
        //                     // $res[$k_mission]['indicator_dipa'][$k_indikator]['sasaran_dipa'][$k_sasaran]['indikator_perkin_dipa'][$k_ind_perkin]['activity'][$k_activity]['rowspan'] = $rowspan_activity;
        //                     // dd($activity);
        //                 }
        //                 if (count($sasaranDipa['indikator_perkin_dipa'][$k_sasaran]['activity']) == 0) {
        //                     // dd('sto');
        //                     // array_slice($res[$k_mission]['indicator_dipa'][$k_indikator]['sasaran_dipa'][$k_sasaran]['indikator_perkin_dipa'], $k_ind_perkin);
        //                     // dd(
        //                     //     $sasaranDipa['indikator_perkin_dipa'][$k_sasaran],
        //                     //     $res[$k_mission]['indicator_dipa'][$k_indikator]['sasaran_dipa'][$k_sasaran]['indikator_perkin_dipa'][$k_ind_perkin]
        //                     // );
        //                     // dd($res[$k_mission]['indicator_dipa'][$k_indikator]['sasaran_dipa']);
        //                     // dd($res[$k_mission]['indicator_dipa'][$k_indikator]['sasaran_dipa']);
        //                 }
        //             }
        //         }
        //         // echo 'Key:' . $k_mission . '-' . $k_indikator . ':' . count($indicator_dipa['sasaran_dipa']) . '----<br>';
        //         if (count($indicator_dipa['sasaran_dipa']) == 0) {
        //             // dd('s');
        //             // dd($res[$k_mission]['indicator_dipa'][$k_indikator]);
        //             array_slice($res[$k_mission]['indicator_dipa'], $k_indikator);
        //         }
        //     }
        // }
        // dd($res);

        foreach ($res as $k_mission => $mission) {
            // dd($mission);
            $rowspan_misi = 0;
            foreach ($mission->indicatorDipa as $k_indikator => $indicator_dipa) {
                $rowspan_iku = 0;
                foreach ($indicator_dipa->sasaranDipa as $k_sasaran => $sasaranDipa) {
                    $rowspan_sasaran = 0;
                    foreach ($sasaranDipa->indikatorPerkinDipa as $k_ind_perkin => $ind_perkin) {
                        $rowspan_ind_perkin = 0;

                        foreach ($ind_perkin->activity as $k_activity => $activity) {
                            if ($activity->dipa_id == $dipa) {

                                $rowspan_activity = 0;
                                foreach ($activity->bi as $k_bi => $bi) {
                                    $rowspan = count($bi['details']);
                                    $new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'][$ind_perkin->id]['child_ind_perkin'][$activity->id]['child_activity'][$bi->id]['bi'] = $bi;
                                    $new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'][$ind_perkin->id]['child_ind_perkin'][$activity->id]['child_activity'][$bi->id]['bi']['rowspan'] = $rowspan;
                                    $new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'][$ind_perkin->id]['child_ind_perkin'][$activity->id]['child_activity'][$bi->id]['detail'] = $bi->details2;
                                    // dd($bi->details2);
                                    $rowspan_activity +=  $rowspan + 1;
                                }
                                if (!empty($new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'][$ind_perkin->id]['child_ind_perkin'][$activity->id]['child_activity'])) {
                                    $new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'][$ind_perkin->id]['child_ind_perkin'][$activity->id]['parent'] = $activity->attributes;
                                    $new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'][$ind_perkin->id]['child_ind_perkin'][$activity->id]['parent']['rowspan'] = $rowspan_activity;
                                    $rowspan_ind_perkin += $rowspan_activity;
                                }
                            }
                        }
                        if (!empty($new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'][$ind_perkin->id]['child_ind_perkin'])) {
                            $new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'][$ind_perkin->id]['parent'] = $ind_perkin->attributes;
                            $new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'][$ind_perkin->id]['parent']['rowspan'] = $rowspan_ind_perkin;
                            $rowspan_sasaran += $rowspan_ind_perkin;
                        }
                    }
                    if (!empty($new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['child_sasaran'])) {
                        $new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['parent'] = $sasaranDipa->attributes;
                        $new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'][$sasaranDipa->id]['parent']['rowspan'] = $rowspan_sasaran;
                        $rowspan_iku += $rowspan_sasaran;
                    }
                }
                if (!empty($new[$mission->id]['child_missi'][$indicator_dipa->id]['child_iku'])) {
                    $new[$mission->id]['child_missi'][$indicator_dipa->id]['parent'] = $indicator_dipa->attributes;
                    $new[$mission->id]['child_missi'][$indicator_dipa->id]['parent']['rowspan'] = $rowspan_iku;
                    $rowspan_misi += $rowspan_iku;
                }
            }
            if (!empty($new[$mission->id]['child_missi'])) {
                $new[$mission->id]['parent'] = $mission->attributes;
                $new[$mission->id]['parent']['rowspan'] = $rowspan_misi;
            }
        }

        // dd($new);
        return $new;

        return $res;
    }
}
