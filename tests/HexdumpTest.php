<?php
use Jhartell\Hexdump\Hexdump;

class HexdumpTest extends PHPUnit_Framework_TestCase
{
    public function testDumpHexAscii()
    {
        $input  = "q3Kyrh5WacCNFFTeopPwEvYKPUQdNADiTZWWBRYjLVD0ZMC2j2";
        $input .= "UWSp7sXNi4aG3XY45N8ybHQhjUrudoybdVRXS71C/fFVbYtmC2";
        $input .= "UQ3t0lee6TlygTnKos6pa0hM7gzFiA/d2YgbiT8eVY9bJpiMQy";
        $input .= "Kb2vunFH8/4geIgs/RJPcTfA==";

        $output  = '00000000  ab 72 b2 ae 1e 56 69 c0  8d 14 54 de a2 93 f0 12  |.r...Vi...T.....|' . "\n";
        $output .= '00000010  f6 0a 3d 44 1d 34 00 e2  4d 95 96 05 16 23 2d 50  |..=D.4..M....#-P|' . "\n";
        $output .= '00000020  f4 64 c0 b6 8f 65 16 4a  9e ec 5c d8 b8 68 6d d7  |.d...e.J..\..hm.|' . "\n";
        $output .= '00000030  63 8e 4d f3 26 c7 42 18  d4 ae e7 68 c9 b7 55 45  |c.M.&.B....h..UE|' . "\n";
        $output .= '00000040  74 bb d4 2f df 15 56 d8  b6 60 b6 51 0d ed d2 57  |t../..V..`.Q...W|' . "\n";
        $output .= '00000050  9e e9 39 72 81 39 ca a2  ce a9 6b 48 4c ee 0c c5  |..9r.9....kHL...|' . "\n";
        $output .= '00000060  88 0f dd d9 88 1b 89 3f  1e 55 8f 5b 26 98 8c 43  |.......?.U.[&..C|' . "\n";
        $output .= '00000070  22 9b da fb a7 14 7f 3f  e2 07 88 82 cf d1 24 f7  |"......?......$.|' . "\n";
        $output .= '00000080  13 7c                                             |.||' . "\n";
        $output .= '00000082' . "\n";

        $hexdump = new Hexdump();
        $hexdump->setEscapeHtml(false);

        $this->assertEquals(
            $output,
            $hexdump->dump(base64_decode($input))
        );
    }

    public function testDumpHexAsciiEscape()
    {
        $input  = "q3Kyrh5WacCNFFTeopPwEvYKPUQdNADiTZWWBRYjLVD0ZMC2j2";
        $input .= "UWSp7sXNi4aG3XY45N8ybHQhjUrudoybdVRXS71C/fFVbYtmC2";
        $input .= "UQ3t0lee6TlygTnKos6pa0hM7gzFiA/d2YgbiT8eVY9bJpiMQy";
        $input .= "Kb2vunFH8/4geIgs/RJPcTfA==";

        $output  = '00000000  ab 72 b2 ae 1e 56 69 c0  8d 14 54 de a2 93 f0 12  |.r...Vi...T.....|' . "\n";
        $output .= '00000010  f6 0a 3d 44 1d 34 00 e2  4d 95 96 05 16 23 2d 50  |..=D.4..M....#-P|' . "\n";
        $output .= '00000020  f4 64 c0 b6 8f 65 16 4a  9e ec 5c d8 b8 68 6d d7  |.d...e.J..\..hm.|' . "\n";
        $output .= '00000030  63 8e 4d f3 26 c7 42 18  d4 ae e7 68 c9 b7 55 45  |c.M.&amp;.B....h..UE|' . "\n";
        $output .= '00000040  74 bb d4 2f df 15 56 d8  b6 60 b6 51 0d ed d2 57  |t../..V..`.Q...W|' . "\n";
        $output .= '00000050  9e e9 39 72 81 39 ca a2  ce a9 6b 48 4c ee 0c c5  |..9r.9....kHL...|' . "\n";
        $output .= '00000060  88 0f dd d9 88 1b 89 3f  1e 55 8f 5b 26 98 8c 43  |.......?.U.[&amp;..C|' . "\n";
        $output .= '00000070  22 9b da fb a7 14 7f 3f  e2 07 88 82 cf d1 24 f7  |&quot;......?......$.|' . "\n";
        $output .= '00000080  13 7c                                             |.||' . "\n";
        $output .= '00000082' . "\n";

        $hexdump = new Hexdump();
        $hexdump->setEscapeHtml(true);

        $this->assertEquals(
            $output,
            $hexdump->dump(base64_decode($input))
        );
    }
}
