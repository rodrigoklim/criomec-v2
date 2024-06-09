<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCompanyDocumentRule implements ValidationRule
{
  /**
   * Run the validation rule.
   *
   * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    if (strlen($value) !== 11 && strlen($value) !== 14) {
      $fail("Documento inválido.");
    }
    if (!$this->validateCpf($value) && !$this->validateCnpj($value)) {
      $fail("Documento inválido.");
    }
  }

  private function validateCpf($document): bool
  {
    for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--) {
      $soma += $document[$i] * $j;
    }

    $resto = $soma % 11;

    if ($document[9] != ($resto < 2 ? 0 : 11 - $resto)) {
      return false;
    }

    for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--) {
      $soma += $document[$i] * $j;
    }

    $resto = $soma % 11;

    return $document[10] == ($resto < 2 ? 0 : 11 - $resto);
  }

  private function validateCnpj($document): bool
  {
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
      $soma += $document[$i] * $j;
      $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    if ($document[12] != ($resto < 2 ? 0 : 11 - $resto)) {
      return false;
    }

    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
      $soma += $document[$i] * $j;
      $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    return $document[13] == ($resto < 2 ? 0 : 11 - $resto);
  }
}
