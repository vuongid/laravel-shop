<?php

namespace App\Enums;

enum GeneralStatus: int
{
  case ACTIVE = 1;
  case INACTIVE = 2;

  // Hàm trả về tên trạng thái
  public function label(): string
  {
    return match ($this) {
      self::ACTIVE => 'Hoạt động X',
      self::INACTIVE => 'Không hoạt động',
    };
  }

  public function color(): string
  {
    return match ($this) {
      self::ACTIVE => 'text-success',
      self::INACTIVE => 'text-secondary',
    };
  }
  // Chuyển thành array, có thể thêm 'Tất cả' nếu cần
  public static function toArray(bool $includeAll = false): array
  {
    $array = $includeAll ? ['all' => 'Tất cả'] : [];

    foreach (self::cases() as $status) {
      $array[$status->value] = $status->label();
    }

    return $array;
  }
}
