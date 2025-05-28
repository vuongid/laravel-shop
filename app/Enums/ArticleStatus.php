<?php

namespace App\Enums;

enum ArticleStatus: int
{
  case PUBLISHED = 1;
  case DRAFT = 2;
  case HIDDEN = 3;

  // Hàm trả về tên trạng thái
  public function label(): string
  {
    return match ($this) {
      self::PUBLISHED => 'Đã đăng',
      self::DRAFT => 'Nháp',
      self::HIDDEN => 'Ẩn',
    };
  }

  public function color(): string
  {
    return match ($this) {
      self::PUBLISHED => 'text-success',
      self::DRAFT => 'text-warning',
      self::HIDDEN => 'text-secondary',
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
