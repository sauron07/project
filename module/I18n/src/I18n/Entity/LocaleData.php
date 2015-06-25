<?php
namespace I18n\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocaleData
 *
 * @ORM\Table(
 *      name="locale_data",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="unique_key_locale_and_alias", columns={"locale_id", "alias"})},
 *      indexes={@ORM\Index(name="IDX_4AD13BB7E559DFD1", columns={"locale_id"})}
 * )
 * @ORM\Entity(repositoryClass="I18n\Repository\LocateData")
 */
class LocaleData
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255, nullable=false)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text", length=65535, nullable=true)
     */
    private $data;

    /**
     * @var \Locale
     *
     * @ORM\ManyToOne(targetEntity="Locale")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="locale_id", referencedColumnName="id")
     * })
     */
    private $locale;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param \Locale $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}
