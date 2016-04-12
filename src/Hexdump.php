<?php
namespace Jhartell\Hexdump;

class Hexdump
{
    /**
     * Convert special characters to HTML entities
     * for ascii printing
     *
     * @var boolean
     */
    protected $escapeHtml = true;

    /**
     * Set escape html
     *
     * @param boolean $value
     * @return object
     */
    public function setEscapeHtml($value = true)
    {
        $this->escapeHtml = (bool)$value;
        return $this;
    }

    /**
     * Dump data in hex + ascii format
     *
     * @param  string $data
     * @return string
     */
    public function dump($data)
    {
        if (is_object($data) || is_array($data)) {
            return '';
        }

        if (strlen($data) < 1) {
            return '';
        }

        $output = '';
        $rows = str_split($data, 16);
        $offset = 0;

        foreach ($rows as $row) {
            $output .= sprintf("%08x  ", $offset);

            $bytes = str_split($row, 1);
            $byteCount = count($bytes);
            $offset += $byteCount;

            foreach ($bytes as $i => $byte) {
                $hex = sprintf("%02x", ord($byte));
                $output .= $hex . ($i == 15 ? "" : " ");

                if ($i == 7 && $byteCount > 8) {
                    $output .= " ";
                }
            }

            while ($byteCount++ < 16) {
                if($byteCount == 9) {
                    $output .= " ";
                }

                $output .= "  " . ($byteCount == 16 ? "" : " ");
            }

            // Output ascii
            $output .= "  ";
            $output .= "|";

            $bytes = str_split($row, 1);
            $byteCount = count($bytes);

            foreach ($bytes as $i => $byte) {
                $val = ord($byte);

                if ($val >= 32 && $val <= 126) {
                    if ($this->escapeHtml) {
                        $output .= htmlspecialchars($byte);
                    } else {
                        $output .= $byte;
                    }
                } else {
                    $output .= ".";
                }
            }

            $output .= "|\n";
        }

        // Print empty offset row
        $output .= sprintf("%08x", $offset);
        $output .= "\n";

        return $output;
    }
}
