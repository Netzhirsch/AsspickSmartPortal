<?php


namespace App\Struct\Email;


class Signature
{
    private string $content;
    private Image $dataProtection;
    private Image $facebook;
    private Image $homepage;
    private Image $imageFilm;
    private Image $impressum;
    private Image $logo;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return Image
     */
    public function getDataProtection(): Image
    {
        return $this->dataProtection;
    }

    /**
     * @param Image $dataProtection
     */
    public function setDataProtection(Image $dataProtection): void
    {
        $this->dataProtection = $dataProtection;
    }

    /**
     * @return Image
     */
    public function getFacebook(): Image
    {
        return $this->facebook;
    }

    /**
     * @param Image $facebook
     */
    public function setFacebook(Image $facebook): void
    {
        $this->facebook = $facebook;
    }

    /**
     * @return Image
     */
    public function getHomepage(): Image
    {
        return $this->homepage;
    }

    /**
     * @param Image $homepage
     */
    public function setHomepage(Image $homepage): void
    {
        $this->homepage = $homepage;
    }

    /**
     * @return Image
     */
    public function getImageFilm(): Image
    {
        return $this->imageFilm;
    }

    /**
     * @param Image $imageFilm
     */
    public function setImageFilm(Image $imageFilm): void
    {
        $this->imageFilm = $imageFilm;
    }

    /**
     * @return Image
     */
    public function getImpressum(): Image
    {
        return $this->impressum;
    }

    /**
     * @param Image $impressum
     */
    public function setImpressum(Image $impressum): void
    {
        $this->impressum = $impressum;
    }

    /**
     * @return Image
     */
    public function getLogo(): Image
    {
        return $this->logo;
    }

    /**
     * @param Image $logo
     */
    public function setLogo(Image $logo): void
    {
        $this->logo = $logo;
    }
}