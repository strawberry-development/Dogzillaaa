<?php

require_once 'Block.php';

class Blockchain {
    public array $chain;
    public int $difficulty;
    public int $eloReward;

    public function __construct() {
        $this->chain = [$this->createGenesisBlock()];
        $this->difficulty = 4;
        $this->eloReward = 100; // Set the Elo reward amount
    }

    private function createGenesisBlock(): Block
    {
        return new Block(0, time(), ["Genesis Block" => "Initial Block in the Chain"], "0");
    }

    public function getLatestBlock(): Block
    {
        return $this->chain[count($this->chain) - 1];
    }

    public function addBlock(mixed $data): void
    {
        $latestBlock = $this->getLatestBlock();
        $newBlock = new Block($latestBlock->index + 1, time(), $data, $latestBlock->hash);
        $newBlock->mineBlock($this->difficulty, $this->eloReward); // Pass the Elo reward
        $this->chain[] = $newBlock;
    }

    public function isChainValid(): bool
    {
        for ($i = 1; $i < count($this->chain); $i++) {
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

    public function getBlockchainSize(): int
    {
        return count($this->chain);
    }

    public function getBlockByIndex(int $index): ?Block
    {
        return $this->chain[$index] ?? null;
    }

    // Add this method to retrieve the chain
    public function getChain(): array
    {
        return $this->chain;
    }

    public function serializeBlockchain(): string
    {
        return json_encode($this->chain, JSON_PRETTY_PRINT);
    }
}