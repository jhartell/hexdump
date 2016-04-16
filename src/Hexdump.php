<?php
namespace Jhartell\Hexdump;

class Hexdump
{
    /**
     * Format identifiers
     */
    const FMT_HEX  = 0; // One byte hexadecimal display
    const FMT_DEC  = 1; // One byte decimal display

    /**
     * Available output formats
     * [format, blocksize]
     *
     * @var array
     */
    protected $formats = [
        self::FMT_HEX  => ['%02x', 1],
        self::FMT_DEC  => ['%03d', 1],
    ];

    /**
     * Current format
     *
     * @var int
     */
    protected $format = self::FMT_HEX;

    /**
     * Print ascii representation
     *
     * @var boolean
     */
    protected $printAscii = true;

    /**
     * Convert special characters to HTML entities
     * for ascii printing
     *
     * @var boolean
     */
    protected $escapeHtml = true;


    /**
     * Set format
     *
     * @param int $format
     * @return object
     */
    public function setFormat($format)
    {
        if (!array_key_exists($format, $this->formats)) {
            throw new Exception("Invalid format", 1);
        }

        $this->format = $format;
        return $this;
    }

    /**
     * Set print ascii
     *
     * @param boolean $value
     * @return object
     */
    public function setPrintAscii($value = true)
    {
        $this->printAscii = (bool)$value;
        return $this;
    }

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
     * Dump data in the selected format
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

        // Format and block size
        list ($fmt, $blockSize) = $this->formats[$this->format];

        $output = '';
        $rows = str_split($data, 16);
        $offset = 0;

        foreach ($rows as $row) {
            $output .= sprintf("%08x  ", $offset);

            $bytes = str_split($row, $blockSize);
            $byteCount = count($bytes) * $blockSize;
            $offset += $byteCount;

            foreach ($bytes as $i => $byte) {
                $hex = sprintf($fmt, ord($byte));
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
            if ($this->printAscii) {
                $output .= "  |";

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

                $output .= "|";
            }

            $output .= "\n";
        }

        // Print empty offset row
        $output .= sprintf("%08x", $offset);
        $output .= "\n";

        return $output;
    }
}
