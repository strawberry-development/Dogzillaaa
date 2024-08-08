<?php

class Block {
    public int $index;
    public int $timestamp;
    public mixed $data;
    public string $previousHash;
    public string $hash;
    public int $nonce;

    public function __construct(int $index, int $timestamp, mixed $data, string $previousHash = '') {
        $this->index = $index;
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->previousHash = $previousHash;
        $this->nonce = 0;
        $this->hash = $this->calculateHash();
    }

    public function calculateHash(): string
    {
        return hash('sha256', $this->index . $this->timestamp . json_encode($this->data) . $this->previousHash . $this->nonce);
    }

    public function mineBlock(int $difficulty): void {
        $target = str_repeat('0', $difficulty);
        while (substr($this->hash, 0, $difficulty) !== $target) {
            $this->nonce++;
            $this->hash = $this->calculateHash();
        }
        echo "Block mined: " . $this->hash . "\n";
    }
}