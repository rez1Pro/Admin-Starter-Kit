<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class RoleData extends Data
{
  public function __construct(
    public int $id,
    public string $name,
    public string $description,
    public ?int $permissions_count,
    public ?int $users_count,
    public string $created_at,
  ) {
    $this->created_at = Carbon::parse($this->created_at)->diffForHumans();
  }
}
