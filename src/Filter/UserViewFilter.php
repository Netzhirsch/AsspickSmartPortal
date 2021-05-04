<?php

namespace App\Filter;

class UserViewFilter {

    private ?string $name = null;

	private ?bool $withFolder = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool|null
     */
    public function getWithFolder(): ?bool
    {
        return $this->withFolder;
    }

    /**
     * @param bool|null $withFolder
     */
    public function setWithFolder(?bool $withFolder): void
    {
        $this->withFolder = $withFolder;
    }
}
