<?php
/**
 * Created by PhpStorm.
 * User: Charline
 * Date: 27/06/2018
 * Time: 16:19
 */

namespace CartBundle\Entity;


class Cart
{
    private $products = [];

    /**
     * array(id => quantity)
     *  Exemple: array(2 => 50)
     *
     * @var array
     */
    private $quantity = [];

    /**
     * @var int
     */
    private $total = 0;

    public function calculTotal(Product $product, int $quantity)
    {
        $subtotal = $product->getPrice() * $quantity;
        $this->total += $subtotal;
        return $subtotal;
    }

    public function countItems()
    {
        return array_sum($this->getQuantity());
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return $this
     * @throws \Exception
     */
    public function addProduct(Product $product, $quantity = 1)
    {
        if ($quantity < 1) {
            throw new \Exception('Quantité non autorisée');
        }

        if (!$this->hasProduct($product)) {
            $this->setProduct($product);
        }

        $this->setQuantity($product, $quantity);

        return $this;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @throws \Exception
     * @return $this|void
     */
    public function removeProduct(Product $product, $quantity = 1)
    {
        if (!$this->hasProduct($product)) {
            return;
        }

        if ($quantity < 1) {
            throw new \Exception('Quantité incorrecte incorrecte');
        }

        $this->quantity[$product->getId()] -= $quantity;

        if ($quantity >= $this->quantity[$product->getId()]) {
            unset($this->products[$product->getId()]);
            unset($this->quantity[$product->getId()]);
            return;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearCart()
    {
        $this->products = [];
        $this->quantity = [];

        return $this;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(Product $product, int $quantity)
    {
        $this->quantity[$product->getId()] += $quantity;
        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct(Product $product)
    {
        $this->products[$product->getId()] = $product;
        $this->quantity[$product->getId()] = 0;

        return $this;
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function hasProduct(Product $product)
    {
        return isset($this->products[$product->getId()]);
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return array
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}