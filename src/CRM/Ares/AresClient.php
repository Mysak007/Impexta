<?php

declare(strict_types=1);

namespace App\CRM\Ares;

use App\CRM\Ares\AresException as ImpextaAresException;
use Defr\Ares;
use Defr\Ares\AresException;
use Defr\Ares\AresRecord;
use InvalidArgumentException;

final class AresClient extends Ares
{
    public const TAX_ID_NOT_SET = "IČ firmy musí být zadáno.";
    public const TAX_ID_NOT_FOUND = "IČ firmy nebylo nalezeno.";
    public const VAT_ID_NOT_FOUND = "DIČ firmy nebylo nalezeno.";
    public const NOTHING_FOUND = "Nic nebylo nalezeno.";
    public const DATABASE_ARES_UNAVAILABLE = "Databáze ARES není dostupná.";
    public const DATABASE_MFCR_UNAVAILABLE = "Databáze MFČR není dostupná.";

    public function findByIdentificationNumber($identificationNumber): AresRecord
    {
        try {
            $result = parent::findByIdentificationNumber($identificationNumber);
        } catch (AresException $aresException) {
            $message = $aresException->getMessage();
            /** @var \Throwable $previous */
            $previous = $aresException->getPrevious();

            switch ($message) {
                case self::TAX_ID_NOT_SET:
                    throw new InvalidArgumentException($message, 400);

                case self::VAT_ID_NOT_FOUND:
                case self::NOTHING_FOUND:
                case self::TAX_ID_NOT_FOUND:
                    throw new SubjectInAresNotFoundException($message, $message, $previous);

                case self::DATABASE_MFCR_UNAVAILABLE:
                case self::DATABASE_ARES_UNAVAILABLE:
                    throw new AresDatabaseUnavailableException($message, $message, $previous);
            }

            throw new ImpextaAresException($message, $message, $previous);
        }

        return $result;
    }
}
