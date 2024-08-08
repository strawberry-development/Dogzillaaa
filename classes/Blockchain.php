<?php

require_once 'Block.php';

class Blockchain {
    private array $chain;
    private int $difficulty;

    public function __construct(int $difficulty = 4) {
        $this->chain = [$this->createGenesisBlock()];
        $this->difficulty = $difficulty;
    }

    private function createGenesisBlock(): Block {
        return new Block(0, time(), ["Genesis Block" => "Initial Block in the Chain"], "0");
    }

    public function getLatestBlock(): Block {
        return end($this->chain);
    }

    public function addBlock(mixed $data): void {
        $latestBlock = $this->getLatestBlock();
        $newBlock = new Block($latestBlock->index + 1, time(), $data, $latestBlock->hash);
        $newBlock->mineBlock($this->difficulty);
        $this->chain[] = $newBlock;
    }

    public function isChainValid(): bool {
        for ($i = 1, $count = count($this->chain); $i < $count; $i++) {
            $currentBlock = $this->chain[$i];
            $previousBlock = $this->chain[$i - 1];

            if ($currentBlock->hash !== $currentBlock->calculateHash()) {
                return false;
            }

            if ($currentBlock->previousHash !== $previousBlock->hash) {
                return false;
            }
        }
        return true;
    }

    public function getBlockchainSize(): int {
        return count($this->chain);
    }

    public function getBlockByIndex(int $index): ?Block {
        return $this->chain[$index] ?? null;
    }

    public function getChain(): array {
        return $this->chain;
    }

    public function serializeBlockchain(): string {
        return json_encode(array_map(fn($block) => [
            'index' => $block->index,
            'timestamp' => $block->timestamp,
            'data' => $block->data,
            'previousHash' => $block->previousHash,
            'hash' => $block->hash,
            'nonce' => $block->nonce
        ], $this->chain), JSON_PRETTY_PRINT);
    }
}