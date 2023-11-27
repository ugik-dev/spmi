<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Criterion extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'code', 'parent_id'];

  /**
   * The "booting" method of the model.
   */
  protected static function boot()
  {
    parent::boot();

    // Before creating or updating
    static::saving(function ($criterion) {
      // If the criterion has a parent, set its level to parent's level + 1
      if ($criterion->parent_id) {
        $parent = Criterion::find($criterion->parent_id);
        $criterion->level = $parent->level + 1;
      } else {
        // If no parent, then it's a root node
        $criterion->level = 1;
      }
    });
  }

  /**
   * Get the minimum and maximum levels of all criteria.
   *
   * @return array
   */
  public static function getMinMaxLevels()
  {
    $result = DB::table('criteria')
      ->selectRaw('MIN(level) as min_level, MAX(level) as max_level')
      ->first();

    return [
      'min_level' => $result->min_level,
      'max_level' => $result->max_level,
    ];
  }

  /**
   * Get the parent criterion.
   */
  public function parent()
  {
    return $this->belongsTo(Criterion::class, 'parent_id');
  }
  /**
   * Get the child criteria.
   */
  public function children()
  {
    return $this->hasMany(Criterion::class, 'parent_id');
  }
  /**
   * Get the children criteria.
   */
  public function nestedChildren()
  {
    return $this->children()->with('nestedChildren');
  }
  /**
   * Get the ancestors criteria.
   */
  public function getAncestors()
  {
    $ancestors = collect();

    $parent = $this->parent;
    while (!is_null($parent)) {
      $ancestors->prepend($parent);
      $parent = $parent->parent;
    }

    return $ancestors;
  }
  /**
   * Get all parent codes if not at root level.
   *
   * @return array
   */
  public function getParentCodes()
  {
    $parentCodes = [];
    if ($this->parent_id !== null) {
      $ancestors = $this->getAncestors();
      foreach ($ancestors as $ancestor) {
        $parentCodes[] = $ancestor->code;
      }
    }
    return $parentCodes;
  }
}
