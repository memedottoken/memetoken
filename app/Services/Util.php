<?php

namespace App\Services;

use InvalidArgumentException;
use kornrunner\Keccak;

class Util
{

    /**
     * get checksummed address from lowercase
     */
    public static function toChecksumAddress(string $address): string
    {
        // Remove '0x' prefix if present and convert to lowercase
        $address = strtolower(str_replace('0x', '', $address));

        // Check if the address is valid length (40 characters without prefix)
        if (!preg_match('/^[0-9a-f]{40}$/i', $address)) {
            throw new InvalidArgumentException('Invalid Ethereum address format');
        }

        // Get the keccak hash of the address
        $hash = Keccak::hash(strtolower($address), 256);

        // Build the checksum address
        $checksumAddress = '0x';

        // Compare the hash with the address to determine which characters should be uppercase
        for ($i = 0; $i < 40; $i++) {
            // Get the current character from the hash and address
            $hashChar = hexdec($hash[$i]);
            $addressChar = $address[$i];

            // If the hash character is greater than or equal to 8, make the address character uppercase
            if ($hashChar >= 8) {
                $checksumAddress .= strtoupper($addressChar);
            } else {
                $checksumAddress .= $addressChar;
            }
        }

        return $checksumAddress;
    }
}
