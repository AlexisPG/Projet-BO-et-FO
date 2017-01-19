<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineExtensions\Query\Mysql\Date;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ProductRepository")
 * @ORM\EntityListeners({"AdminBundle\Listener\ProductListener"})
 */
class Product
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="titleFR", type="string", length=100)
     * @Assert\Length(
     *     min = 5,
     *     minMessage = "{{ limit }} caractères min",
     *     max = 100,
     *     maxMessage = "{{ limit }} caractères max",
     * )
     * @Assert\NotBlank(message="product.titleFR")
     */
    private $titleFR;

    /**
     * @var string
     * @ORM\Column(name="titleEN", type="string", length=100)
     * @Assert\Length(
     *     min = 5,
     *     minMessage = "{{ limit }} caractères min",
     *     max = 100,
     *     maxMessage = "{{ limit }} caractères max",
     * )
     * @Assert\NotBlank(message="product.titleEN")
     */
    private $titleEN;

    /**
     * @var string
     * @Assert\NotBlank(message="product.descriptionFR")
     * @Assert\Length(
     *     min = 5,
     *     minMessage = "{{ limit }} caractères min",
     *     max = 100,
     *     maxMessage = "{{ limit }} caractères max"
     * )
     * @ORM\Column(name="descriptionFR", type="text")
     */
    private $descriptionFR;

    /**
     * @var string
     * @Assert\NotBlank(message="product.descriptionEN")
     * @Assert\Length(
     *     min = 5,
     *     minMessage = "{{ limit }} caractères min",
     *     max = 100,
     *     maxMessage = "{{ limit }} caractères max",
     * )
     * @ORM\Column(name="descriptionEN", type="text")
     */
    private $descriptionEN;

    /**
     * @var float
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 300
     * )
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 0)
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Brand")
     * @ORM\JoinColumn(name="id_brand", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Veuillez choisir un champs")
     */
    private $marque;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="Products")
     * @ORM\JoinTable(name="products_categories")
     */
    private $categories;

    /**
     * @var date
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var date
     * @ORM\Column(name="date_edit", type="datetime")
     */
    private $dateEdit;

    /**
     * @var string
     * @ORM\Column(name="image", type="string")
     */
    private $image;

    /**
     * One Products have Many Comments
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="product")
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titleFR
     *
     * @param string $titleFR
     *
     * @return Product
     */
    public function setTitleFR($titleFR)
    {
        $this->titleFR = $titleFR;

        return $this;
    }

    /**
     * Get titleFR
     *
     * @return string
     */
    public function getTitleFR()
    {
        return $this->titleFR;
    }

    /**
     * Set titleEN
     *
     * @param string $titleEN
     *
     * @return Product
     */
    public function setTitleEN($titleEN)
    {
        $this->titleEN = $titleEN;

        return $this;
    }

    /**
     * Get titleEN
     *
     * @return string
     */
    public function getTitleEN()
    {
        return $this->titleEN;
    }

    /**
     * Set descriptionFR
     *
     * @param string $descriptionFR
     *
     * @return Product
     */
    public function setDescriptionFR($descriptionFR)
    {
        $this->descriptionFR = $descriptionFR;

        return $this;
    }

    /**
     * Get descriptionFR
     *
     * @return string
     */
    public function getDescriptionFR()
    {
        return $this->descriptionFR;
    }

    /**
     * Set descriptionEN
     *
     * @param string $descriptionEN
     *
     * @return Product
     */
    public function setDescriptionEN($descriptionEN)
    {
        $this->descriptionEN = $descriptionEN;

        return $this;
    }

    /**
     * Get descriptionEN
     *
     * @return string
     */
    public function getDescriptionEN()
    {
        return $this->descriptionEN;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Product
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateEdit
     *
     * @param \DateTime $dateEdit
     *
     * @return Product
     */
    public function setDateEdit($dateEdit)
    {
        $this->dateEdit = $dateEdit;

        return $this;
    }

    /**
     * Get dateEdit
     *
     * @return \DateTime
     */
    public function getDateEdit()
    {
        return $this->dateEdit;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set marque
     *
     * @param \AdminBundle\Entity\Brand $marque
     *
     * @return Product
     */
    public function setMarque(\AdminBundle\Entity\Brand $marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \AdminBundle\Entity\Brand
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Add category
     *
     * @param \AdminBundle\Entity\Category $category
     *
     * @return Product
     */
    public function addCategory(\AdminBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AdminBundle\Entity\Category $category
     */
    public function removeCategory(\AdminBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Product
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
