<?php

namespace App\Install\Helpers;

class EnvHelper
{
    /**
     * Path to .env file
     *
     * @var string
     */
    protected $envPath;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
    }

    /**
     * Update existing .env variable
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function updateEnv(string $key, string $value): bool
    {
        if (file_exists($this->envPath)) {
            $content = file_get_contents($this->envPath);

            // Escape any quotes in the value
            $value = str_replace('"', '\"', $value);

            // Check if key exists
            if (preg_match("/^{$key}=/m", $content)) {
                // Update existing key
                $content = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}=\"{$value}\"",
                    $content
                );
            } else {
                // Add new key
                $content .= PHP_EOL . "{$key}=\"{$value}\"";
            }

            return file_put_contents($this->envPath, $content) !== false;
        }

        return false;
    }

    /**
     * Get current env value
     *
     * @param string $key
     * @return string|null
     */
    public function getEnv(string $key): ?string
    {
        if (file_exists($this->envPath)) {
            $content = file_get_contents($this->envPath);

            // Match until end of line and handle quoted and unquoted values
            if (preg_match("/^{$key}=[\"']?([^\"'\r\n]+)[\"']?/m", $content, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Update multiple env variables at once
     *
     * @param array $values
     * @return bool
     */
    public function updateMultipleEnv(array $values): bool
    {
        $success = true;

        foreach ($values as $key => $value) {
            if (!$this->updateEnv($key, $value)) {
                $success = false;
            }
        }

        return $success;
    }
}
