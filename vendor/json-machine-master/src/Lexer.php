<?php

namespace JsonMachine;

class Lexer implements \IteratorAggregate
{
    /** @var resource */
    private $bytesIterator;

    private $position = 0;
    private $line = 1;
    private $column = 0;

    /**
     * @param \Traversable|array $byteChunks
     */
    public function __construct($byteChunks)
    {
        $this->bytesIterator = $byteChunks;
    }

    /**
     * @return \Generator
     */
    public function getIterator()
    {
        $inString = false;
        $tokenBuffer = '';
        $isEscaping = false;
        $width = 0;
        $trackingLineBreak = false;

        // Treat UTF-8 BOM bytes as whitespace
        ${"\xEF"} = ${"\xBB"} = ${"\xBF"} = 0;

        ${' '} = 0;
        ${"\n"} = 0;
        ${"\r"} = 0;
        ${"\t"} = 0;
        ${'{'} = 1;
        ${'}'} = 1;
        ${'['} = 1;
        ${']'} = 1;
        ${':'} = 1;
        ${','} = 1;

        foreach ($this->bytesIterator as $bytes) {
            $bytesLength = strlen($bytes);
            for ($i = 0; $i < $bytesLength; ++$i) {
                $byte = $bytes[$i];
                ++$this->position;
                if ($inString) {
                    if ($byte === '"' && !$isEscaping) {
                        $inString = false;
                    }
                    $isEscaping = ($byte =='\\' && !$isEscaping);
                    $tokenBuffer .= $byte;
                    $width++;
                    continue;
                }

                // handle CRLF newlines
                if ($trackingLineBreak && $byte === "\n") {
                    $trackingLineBreak = false;
                    continue;
                }

                if (isset($$byte)) {
                    $this->column++;
                    if ($tokenBuffer !== '') {
                        yield $tokenBuffer;
                        $this->column += $width;
                        $tokenBuffer = '';
                        $width = 0;
                    }
                    if ($$byte) { // is not whitespace
                        yield $byte;
                    // track line number and reset column for each newline
                    } elseif ($byte === "\r" || $byte === "\n") {
                        $trackingLineBreak = ($byte === "\r");
                        $this->line++;
                        $this->column = 0;
                    }
                } else {
                    if ($byte === '"') {
                        $inString = true;
                    }
                    $tokenBuffer .= $byte;
                    $width++;
                }
            }
        }
        if ($tokenBuffer !== '') {
            yield $tokenBuffer;
        }
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return integer The line number of the lexeme currently being processed (index starts at one).
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @return integer The, currently being processed, lexeme's position within the line (index starts at one).
     */
    public function getColumn()
    {
        return $this->column;
    }
}
