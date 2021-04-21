<?php


namespace App\Struct\Email;


class Image
{
    private string $filepath;
    private string $cid;
    private Signature $signature;

    /**
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }

    /**
     * @param string $filepath
     */
    public function setFilepath(string $filepath): void
    {
        $this->filepath = $filepath;
    }

    /**
     * @return string
     */
    public function getCid(): string
    {
        return $this->cid;
    }

    /**
     * @param string $cid
     */
    public function setCid(string $cid): void
    {
        $this->cid = $cid;
    }

    public function getSignature(): Signature
    {
        return $this->signature;
    }

    public function setSignature(Signature $signature): self
    {
        $this->signature = $signature;

        return $this;
    }
}